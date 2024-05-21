<!DOCTYPE html>
<html>
<head>
    <title> CV - {{ $humanResource->first_name }} {{ $humanResource->last_name }}</title>
    <style>
        body {
            font-family: 'Vamtam', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-family: 'Vamtam', sans-serif;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #010ED0;
            font-family: 'Vamtam', sans-serif;
            font-size: 1.7em;
            border-bottom: 2px solid #010ED0;
            padding-bottom: 1px;
            margin-bottom: -10px;
        }

        .section h3 {
            font-family: 'Vamtam', sans-serif;
            font-size: 1.5em;
            margin-bottom: -10px;
        }
        .section p {
            margin-bottom: -10px;
        }
        .project {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            padding-left: 20px;
        }
        .project-title {
            font-size: 1.2em;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }
        .project-list {
            list-style-type: none;
            padding-left: 0;
            margin-top: 2px;
            margin-bottom: 10px;
        }
        .project-list li {
            margin-bottom: 2px;
        }

        .detail-counter{
            margin-top: 30px;
            margin-bottom: -5px;
        }
        .detail-counter,
        .project-counter {
            margin-right: 5px;
            font-weight: bold;
        }

        .project-counter{
            margin-bottom: -20px;
        }

        .project-info{
            font-size: 1.2em;
            padding-bottom: -20px;
        }

        .project-info2{
            font-size: 0.9em;
        }

        .projects-title{
            margin-bottom: -30px;
        }

        .title2 {
            color: #003147;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .about .box {
            display: flex;
            flex-direction: row;
            margin: 20px 0;
        }

        .about .box .year_company{
            min-width: 150px;
        }

        .about .box .year_company h5{
            text-transform: uppercase;
            color: #848c90;
            font-weight: 600;
        }

        .about .box .text h4 {
            text-transform: uppercase;
            color: #2a7da2;
            font-size: 16px;
        }

        .div_mare{
            width:100%;
            display: inline;
        }

        .partea_stanga{
            width: 30%;
        }

        .partea_dreapta{
            width: 70%
        }
    </style>
</head>
<body>
    <h1>CV - {{ $humanResource->first_name }} {{ $humanResource->last_name }}</h1>
    <div class="section">
        <h2>GENERAL INFORMATION</h2>
        <p><strong>First Name:</strong> {{ $humanResource->first_name }}</p>
        <p><strong>Last Name:</strong> {{ $humanResource->last_name }}</p>
        <p><strong>Date of Birth:</strong> {{ $humanResource->date_of_birth }}</p>
    </div>
    @php
        $academicCounter = 1;
        $professionalCounter = 1;
    @endphp
    @foreach($humanResource->details as $detail)
        @if($detail->is_academic)
            @if($academicCounter == 1)
                <div class="section">
                    <h2>ACADEMIC INFORMATION</h2>
                    <ul class="project-list">
            @endif
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <h3 class="detail-counter">{{ $academicCounter }}) {{ $detail->name }}</h3>
                        <p><strong>Start:</strong> {{ $detail->start }}</p>
                        <p><strong>End:</strong> {{ $detail->end }}</p>
                        <p><strong>Type:</strong> {{ $detail->type }}</p>
                    </td>
                    <td style="width: 50%;">
                        <h4 class="projects-title">Projects:</h4>
                        <ul class="project-list">
                            @foreach($detail->projects as $project)
                                <li class="project">
                                    {{-- <span class="project-counter">{{ $loop->iteration }})</span> --}}
                                    <p class="project-info"> <strong>Project {{ $loop->iteration }} - {{ $project->name }} </strong> </p>
                                    <p class="project-info2 description"><strong>Description:</strong> {{ $project->description }}</p>
                                    <p class="project-info2"><strong>Technologies:</strong> {{ implode(', ', json_decode($project->technologies)) }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
            @php $academicCounter++; @endphp
        @else
            @if($professionalCounter == 1)
                </ul>
                </div>
                <div class="section">
                    <h2>PROFESSIONAL INFORMATION</h2>
                    <ul class="project-list">
            @endif
            <li>
                {{-- <span class="detail-counter">{{ $professionalCounter }})</span> --}}
                <h3 class="detail-counter">{{ $professionalCounter }}) {{ $detail->name }}</h3>
                <p><strong>Start:</strong> {{ $detail->start }}</p>
                <p><strong>End:</strong> {{ $detail->end }}</p>
                <p><strong>Type:</strong> {{ $detail->type }}</p>
                <h4 class="projects-title">Projects:</h4>
                <ul class="project-list">
                    @foreach($detail->projects as $project)
                        <li class="project">
                            {{-- <span class="project-counter">{{ $loop->iteration }})</span> --}}
                            <p class="project-info"> <strong>Project {{ $loop->iteration }} - {{ $project->name }} </strong> </p>
                            <p class="project-info2 description"><strong>Description:</strong> {{ $project->description }}</p>
                            <p class="project-info2"><strong>Technologies:</strong> {{ implode(', ', json_decode($project->technologies)) }}</p>
                        </li>
                    @endforeach
                </ul>
            </li>
            @php $professionalCounter++; @endphp
        @endif
    @endforeach
    </ul>

    </div>
</body>
</html>
