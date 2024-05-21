<?php

namespace App\Console\Commands;

use App\Models\ColdEmailingCredentials;
use App\Models\ColdEmailingRules;
use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\EmailThread;
use App\Models\EmailThreadMessage;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class ColdEmailingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cold-emailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coldEmailingRules = ColdEmailingRules::all();

        $sentConnectionString = '{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Sent Mail';
        $inboxConnectionString = '{imap.gmail.com:993/imap/ssl/novalidate-cert}Inbox';
        $spamConnectionString = '{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Spam';

        $mailBoxes = [
            $sentConnectionString,
            $inboxConnectionString,
            $spamConnectionString
        ];

        $messages = [];
        foreach ($coldEmailingRules as $coldEmailingRule){
            $coldEmailingCredential = $coldEmailingRule->coldEmailingCredential;
            $username = $coldEmailingCredential->username;
            $password = $coldEmailingCredential->password;

            if (!empty($coldEmailingRule->since)){
                if (!empty($coldEmailingRule->last_check_date)){
                    $sinceDate = new Carbon($coldEmailingRule->since);
                    $lastCheckDate = new Carbon($coldEmailingRule->last_check_date);
                    if ($sinceDate > $lastCheckDate){
                        $sinceDate = new Carbon($coldEmailingRule->since);

                        $beforeDate = new Carbon($coldEmailingRule->since);
                        $beforeDate->addDay();
                    } else{
                        $sinceDate = new Carbon($coldEmailingRule->last_check_date);

                        $beforeDate = new Carbon($coldEmailingRule->last_check_date);
                        $beforeDate->addDay();
                    }
                } else{
                    $sinceDate = new Carbon($coldEmailingRule->since);

                    $beforeDate = new Carbon($coldEmailingRule->since);
                    $beforeDate->addDay();
                }
            }

            $now = new Carbon();
            $now->addDay();
            while($beforeDate <= $now){
                foreach ($mailBoxes as $mailBox){
                    try{
                        $connection = \imap_open($mailBox, $username, $password);

                        $coldEmailingCredential->validated = 1;
                        $coldEmailingCredential->last_error = '';
                        $coldEmailingCredential->save();

                        $searchString = $this->buildSearchString($coldEmailingRule, $sinceDate, $beforeDate);
//                        echo $username.' '.$searchString."\n";
                        $emailData = imap_search($connection, $searchString);
                        foreach ($emailData as $emailIdent) {
                            $messageInfo = $this->extractMessageInfo($connection, $emailIdent, $coldEmailingRule);
                            foreach ($messageInfo as $key => $value){
                                $messages[$messageInfo['threadId']][$messageInfo['messageId']][$key] = $value;
                            }

                            $threadMessages = $this->sortThread($messages[$messageInfo['threadId']]);
                            $messages[$messageInfo['threadId']] = $threadMessages;
                        }
                    } catch(\Exception|\Error $e){
                        $coldEmailingCredential->validated = 0;
                        $coldEmailingCredential->last_error = '1-'.imap_last_error().' '.$e->getMessage();
                        $coldEmailingCredential->save();

                        $coldEmailingRule->last_error = '1-'.imap_last_error().' '.$e->getMessage();
                        $coldEmailingRule->save();
                    }
                }
//                var_dump(sizeof($messages));
//                echo "\n";
                //Process messages - create companies, contacts, tasks, messages
                $this->processImapMessages($messages, $coldEmailingRule);

                //Update last check date
                $coldEmailingCredential->validated = 1;
                $coldEmailingCredential->last_error = '';
                $coldEmailingCredential->save();

                $coldEmailingRule->last_check_date = $sinceDate->format('Y-m-d');
                $coldEmailingRule->last_error = '';
                $coldEmailingRule->save();

                $beforeDate->addDay();
                $sinceDate->addDay();
            }
        }
    }

    public function buildSearchString($coldEmailingRule, $sinceDate, $beforeDate)
    {
        $searchCriterias = [];

        $searchCriterias[] = 'SUBJECT "'.$coldEmailingRule->subject.'"';
        $searchCriterias[] = 'SINCE '.$sinceDate->format('d-M-Y');
        $searchCriterias[] = 'BEFORE '.$beforeDate->format('d-M-Y');

        return implode(' ', $searchCriterias);
    }

    public function processImapMessages($imapMessages, $coldEmailingRule)
    {
        foreach ($imapMessages as $threadMessages){
            foreach ($threadMessages as $messageIdentifier => $message){
                if($message['type'] == 'received'){
                    $companyName = $message['fromContact']['companyName'];
                    $contactFirstName = $message['fromContact']['firstName'];
                    $contactLastName = $message['fromContact']['lastName'];
                    $contactEmail = $message['fromContact']['email'];
                } else{
                    $companyName = $message['toContact']['companyName'];
                    $contactFirstName = $message['toContact']['firstName'];
                    $contactLastName = $message['toContact']['lastName'];
                    $contactEmail = $message['toContact']['email'];
                }

                $companyContact = CompanyContact::where([
                    'email' => $contactEmail
                ])->first();
                if (empty($companyContact)){
                    $company = Company::firstOrCreate([
                        'name' => $companyName
                    ]);
                    $companyContact = CompanyContact::create([
                        'company_id' => $company->id,
                        'first_name' => $contactFirstName,
                        'last_name' => $contactLastName,
                        'email' => $contactEmail
                    ]);
                }

                $emailThread = EmailThread::firstOrCreate([
                    'identifier' => $message['threadId'],
                    'companies_contacts_id' => $companyContact->id
                ]);
                $emailThreadMessage = EmailThreadMessage::firstOrCreate([
                    'emails_threads_id' => $emailThread->id,
                    'subject' => $message['subject'],
                    'message' => $message['message'],
                    'date' => new Carbon($message['date']),
                    'from' => $message['from'],
                    'to' => $message['to'],
                    'identifier' => $messageIdentifier,
                ]);

                if (!empty($coldEmailingRule->tasks_lists_id) && !empty($coldEmailingRule->user_id) && $message['type'] == 'received'){
                    $task = Task::where([
                        "emails_threads_messages_id" => $emailThreadMessage->id,
                    ])->first();
                    if (!empty($task)){
                        continue;
                    }

                    $now = new Carbon();
                    $createdTask = Task::firstOrCreate([
                        'title' => "Reply to contact ".$message['fromContact']['email'],
                        'priority' => "high",
                        'status' => 'pending',
                        'due_date' => $now->format('Y-m-d'),
                        'user_id' => $coldEmailingRule->user_id,
                        'tasks_lists_id' => $coldEmailingRule->tasks_lists_id,
                        'type' => "cold_emailing",
                        "emails_threads_id" => $emailThread->id,
                        "emails_threads_messages_id" => $emailThreadMessage->id,
                        "companies_contact_id" => $companyContact->id,
                        "email_thread_message_identifier" => $messageIdentifier
                    ]);

                    if(strpos($emailThreadMessage->from, "postmaster@") !== false){
                        $createdTask->status = 'done';
                        $createdTask->auto_responder_type = 'failed';
                        $createdTask->save();
                    }
                }
            }
        }
    }

    public function sortThread($threadMessages)
    {
        uasort($threadMessages, [&$this, 'sortMessages']);

        return $threadMessages;
    }

    public function sortMessages($a, $b)
    {
        return $a['formattedDate'] > $b['formattedDate'];
    }

    public function extractMessageInfo($connection, $emailIdent, $coldEmailingRule)
    {
        $overview = imap_fetch_overview($connection, $emailIdent, 0);
        $message = imap_fetchbody($connection, $emailIdent, 1);

        $cleanText = preg_replace('/(^\w.+:\n)?(^>.*(\n|$))+/mi', '', $message);
        $days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        foreach ($days as $day){
            $explodedCleanMessage = explode("On ".$day, $cleanText);
            if(sizeof($explodedCleanMessage) > 1){
                $cleanText = $explodedCleanMessage[0];
            }
        }

        $threadId = $overview[0]->message_id;
        $messageId = $overview[0]->message_id;
        if(!empty($overview[0]->references)){
            $references = explode(' ', $overview[0]->references);
            $threadId = $references[0];
        }

        $formattedDate = new Carbon($overview[0]->date);
        $formattedDate = $formattedDate->format('Y-m-d G:i:s');

        $fromData = $this->getContactParts($overview[0]->from);
        $toData = $this->getContactParts($overview[0]->to);

        return [
            'messageId' => $messageId,
            'threadId' => $threadId,
            'subject' => $overview[0]->subject,
            'date' => $overview[0]->date,
            'formattedDate' => $formattedDate,
            'message' => $cleanText,
            'from' => $overview[0]->from,
            'to' => $overview[0]->to,
            'fromContact' => $fromData,
            'toContact' => $toData,
            'type' => $coldEmailingRule->coldEmailingCredential->email == $fromData['email'] ? "sent" : "received"
        ];
    }

    public function getContactParts($string)
    {
        $explodedString = explode(' <', $string);

        if (sizeof($explodedString) > 1){
            $name = $explodedString[0];
            $email = trim($explodedString[1], '>');
        } else{
            $name = trim($explodedString[0], '>');
            $email = trim($explodedString[0], '>');
        }

        $nameParts = explode(' ', $name);
        if(sizeof($nameParts) == 1){
            $firstName = $nameParts[0];
            $firstName = explode('@', $firstName)[0];
            $lastName = '-';
        } else{
            $firstName = $nameParts[0];
            unset($nameParts[0]);
            $lastName = implode(' ', $nameParts);
        }

        $companyName = explode('@', $email);
        $companyName = explode('.', $companyName[1])[0];
        $commonCompanies = ['gmail', 'yahoo', 'hotmail', 'outlook'];
        if(in_array($companyName, $commonCompanies)){
            $companyName = $firstName.' '.$lastName;
        }

        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'companyName' => ucfirst($companyName)
        ];
    }

}
