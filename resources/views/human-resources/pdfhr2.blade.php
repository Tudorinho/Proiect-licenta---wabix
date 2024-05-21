<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  background: lightblue;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.container {
  position: relative;
  width: 100%;
  max-width: 1000px;
  min-height: 1000px;
  background: #fff;
  margin: 50px;
  display: grid;
  grid-template-columns: 1fr 2fr;
  box-shadow: 0 35px 55px rgba(0, 0, 0, 0.1);
}

.container .left_side {
  position: relative;
  background: #003147;
  padding: 40px;
}

.profileText {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.profileText .imgBx {
  position: relative;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
}

.profileText .imgBx img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profileText h2 {
  color: #fff;
  font-size: 1.5em;
  margin-top: 20px;
  text-transform: uppercase;
  text-align: center;
  font-weight: 600;
  line-height: 1.4em;
}

.profileText h2 span {
  font-size: 0.8em;
  font-weight: 300;
}

.contactInfo {
  padding-top: 40px;
}

.title {
  color: #fff;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 1px;
  margin-bottom: 20px;
}

.contactInfo ul {
  position: relative;
}

.contactInfo ul li {
  position: relative;
  list-style: none;
  margin: 10px 0;
  cursor: pointer;
}

.contactInfo ul li .icon {
  display: inline-block;
  width: 30px;
  font-size: 18px;
  color: #03a9f4;
}

.contactInfo ul li span {
  color: #fff;
  font-weight: 300;
}

.contactInfo.education li {
  margin-bottom: 15px;
}

.contactInfo.education h5 {
  color: #03a9f4;
  font-weight: 500;
}

.contactInfo.education h4:nth-child(2) {
  color: #fff;
  font-weight: 500;
}

.contactInfo.education h4 {
  color: #fff;
  font-weight: 300;
}

.contactInfo.language .percent {
  position: relative;
  width: 100%;
  height: 6px;
  background: #081921;
  display: block;
  margin-top: 5px;
}

.contactInfo.language .percent div {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: #03a9f4;
}

.container .right_side {
  position: relative;
  background: #fff;
  padding: 40px;
}

.about {
  margin-bottom: 50px;
}

.about:last-child {
  margin-bottom: 0;
}

.title2 {
  color: #003147;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 10px;
}

p {
  color: #333;
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

.skills .box {
  position: relative;
  width: 100%;
  display: grid;
  grid-template-columns: 150px 1fr;
  justify-content: center;
  align-items: center;
}

.skills .box h4 {
  text-transform: uppercase;
  color: #848c99;
  font-weight: 500;
}

.skills .box .percent {
  position: relative;
  width: 100%;
  height: 10px;
  background: #f0f0f0;
}

.skills .box .percent div {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: #03a9f4;
}

.interest ul {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
}

.interest ul li {
  list-style: none;
  color: #333;
  font-weight: 500;
  margin: 10px 0;
}

.interest ul li .fa {
  color: #03a9f4;
  font-size: 18px;
  width: 20px;
  margin-right: 2px;
}

@media (max-width: 1000px) {
  .container {
    margin: 10px;
    grid-template-columns: repeat(1, 1fr);
  }

  .interest ul {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .about .box {
    flex-direction: column;
  }

  .about .box .year_company {
    min-width: 150px;
    margin-bottom: 5px;
  }

  .interest ul {
    grid-template-columns: repeat(1, 1fr);
  }
}

    </style>
    <link rel="icon" href="img/resume1.svg" type="image/x-icon">
    <title>Dan Tudor - Resume</title>
</head>

<body>
    <div class="container">


        <div class="left_side">
            <div class="profileText">
                <div class="imgBx">
                    <img src="img/poza1.jpg" alt="picture with me" id="myPicture">
                </div>
                <h2>Dan-Mihai Tudor<br><span>PHP Developer Intern at <a
                            href="https://meditatii.ro/">Meditatii.ro</a></span></h2>
            </div>

            <div class="contactInfo">
                <h3 class="title">Contact Info</h3>
                <ul>
                    <li>
                        <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <span class="text"><a href="tel:+40768923615">My phone number</a></span>
                    </li>
                    <li>
                        <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <span class="text"><a href="mailto:dantudor_02@yahoo.com">My Yahoo Mail address</a></span>
                    </li>
                    <li>
                        <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <span class="text"><a href="mailto:tdm2002dmt@gmail.com">My Gmail address</a></span>
                    </li>
                    <li>
                        <span class="icon"><i class="fa fa-linkedin" aria-hidden="true"></i></span>
                        <span class="text"><a href="https://www.linkedin.com/in/dan-mihai-tudor-8baaa9282/"> My
                                LinkedIn</a></span>
                    </li>
                    <li>
                        <span class="icon"><i class="fa fa-github" aria-hidden="true"></i></span>
                        <span class="text"><a href="https://github.com/Tudorinho">My GitHub</a></span>
                    </li>
                    <li>
                        <span class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                        <span class="text">Bucharest, Romania</span>
                    </li>
                </ul>
            </div>

            <div class="contactInfo education">
                <h3 class="title">Work Experience</h3>
                <ul>
                    <li>
                        <h5>2023 - present</h5>
                        <h4>PHP Developer Intern</h4>
                        <h4><a href="https://meditatii.ro/">Meditatii.ro</a></h4>
                    </li>
                </ul>
            </div>

            <div class="contactInfo education">
                <h3 class="title">Education</h3>
                <ul>
                    <li>
                        <h5>2021 - present</h5>
                        <h4>Bachelor Degree in Computer Science</h4>
                        <h4>University of Bucharest, Faculty of Mathematics and Computer Science</h4>
                    </li>
                    <li>
                        <h5>2013 - 2021</h5>
                        <h4>Student</h4>
                        <h4>"Spiru Haret" National College, Tecuci</h4>
                    </li>

                </ul>
            </div>

            <div class="contactInfo language">
                <h3 class="title">Languages</h3>
                <ul>
                    <li>
                        <span class="text">Romanian</span>
                        <span class="percent">
                            <div style="width: 100%;"></div>
                        </span>
                    </li>
                    <li>
                        <span class="text">English</span>
                        <span class="percent">
                            <div style="width: 92%;"></div>
                        </span>
                    </li>
                    <li>
                        <span class="text">French</span>
                        <span class="percent">
                            <div style="width: 25%;"></div>
                        </span>
                    </li>
                </ul>
            </div>

        </div>



        <div class="right_side">
            <div class="about">
                <h2 class="title2">Profile</h2>
                <p>
                    Passionate and skilled 21-year-old college student, competent in HTML, CSS, JavaScript, PHP, Java
                    and SQL who is looking for a job as a web or software developer, where my skills can be put to use.
                    <br>
                    I am a dedicated team player who promotes creative thinking and deepens technical understanding. I'm
                    committed to staying current on market trends and cutting-edge technology.
                    <br>
                    I am confident that I possess the conceptual knowledge and problem-solving skills necessary to
                    succeed in this industry as a result of my courses and projects, which have given me first-hand
                    experience by building a variety of websites, software programs, and apps.
                </p>
            </div>

            <div class="about">
                <h2 class="title2">Experience</h2>
                <div class="box">
                    <div class="year_company">
                        <h5>2019 - Present</h5>
                        <h5>Company Name</h5>
                    </div>
                    <div class="text">
                        <h4>Senior UX Designer</h4>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus eius qui laborum deleniti eos sit quae veritatis sequi esse sunt placeat possimus non repudiandae cumque quasi, perspiciatis ad nobis autem!</p>
                    </div>

                </div>
            </div>

            <div class="about skills">
                <h2 class="title2">Professional Skills</h2>
                <div class="box">
                    <h4>HTML</h4>
                    <div class="percent">
                        <div style="width: 75%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>CSS</h4>
                    <div class="percent">
                        <div style="width: 75%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>Tailwind CSS</h4>
                    <div class="percent">
                        <div style="width: 55%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>JavaScript</h4>
                    <div class="percent">
                        <div style="width: 60%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>PHP</h4>
                    <div class="percent">
                        <div style="width: 70%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>Laravel</h4>
                    <div class="percent">
                        <div style="width: 70%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>SQL</h4>
                    <div class="percent">
                        <div style="width: 70%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>UI/UX Design(Figma)</h4>
                    <div class="percent">
                        <div style="width: 25%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>Java</h4>
                    <div class="percent">
                        <div style="width: 60%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>C++</h4>
                    <div class="percent">
                        <div style="width: 40%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>Python</h4>
                    <div class="percent">
                        <div style="width: 45%;"></div>
                    </div>
                </div>
                <div class="box">
                    <h4>Linux</h4>
                    <div class="percent">
                        <div style="width: 30%;"></div>
                    </div>
                </div>
            </div>

            <div class="about interest">
                <h2 class="title2">Hobbies/Interests</h2>
                <ul>
                    <li><i class="fa fa-futbol-o" aria-hidden="true"></i>Football</li>
                    <li><i class="fa fa-film" aria-hidden="true"></i>Movies</li>
                    <li><i class="fa fa-book" aria-hidden="true"></i>Reading</li>
                    <li><i class="fa fa-users" aria-hidden="true"></i>Socialising</li>
                    <li><i class="fa fa-gamepad" aria-hidden="true"></i>Gaming</li>
                    <li><i class="fa fa-headphones" aria-hidden="true"></i>Music</li>
                    <li><i class="fa fa-heartbeat" aria-hidden="true"></i>Health</li>
                    <li><i class="fa fa-car" aria-hidden="true"></i>Driving</li>
                </ul>

            </div>

        </div>



    </div>

</body>

</html>
