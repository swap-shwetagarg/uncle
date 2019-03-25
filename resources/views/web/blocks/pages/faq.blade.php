@extends('web.layouts.index')

@section('title', 'Frequently Asked Questions | Uncle Fitter')
@section('description', 'Forget the repair shop hassle. Our highly skilled mobile mechanics come to you at your most convenient location and time.')

@section('content')

<div class="container-fluid no-padding about-our-mechanic">
    @include('web/blocks/pages/navbar-alt')

    <div class="logo">
        <a href="{{ URL('/') }}">
            <img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="logo">
        </a>
    </div>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner slider--caption">        
            <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/ufhomepage1.jpg')}});">
                <div class="slider--img--small" style="background: url({{ asset('web/img/about-our-mechanic-mobile.jpg') }}) no-repeat;">
                </div>
                <div class="carousel-caption">
                    <h1>Frequently Asked Questions </h1>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container-fluid no-padding faq-container" id="about-us">
    <div class="container faq">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading1">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq1" aria-expanded="true" aria-controls="faq1">
                                    What does UncleFitter actually do?
                                </a>
                            </h4>
                        </div>
                        <div id="faq1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                            <div class="panel-body">
                                We are an online mobile auto mechanic company. Anyone can visit our website or mobile app and with some basic information like year, make, model & the services needed, they will be able to get a fair pricing for the service. We will then match you with one of our well-experienced & qualified mechanic who can come to your location (home/office) and service your car. We offer pricing that is 30-40% less than what a repair shop/dealership offers and all our service come with a 6 month/3000 mile warranty. Our mechanics are well paid because there are no overhead costs. It's a win-win situation for our mechanics and our customers.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading2">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq2" aria-expanded="false" aria-controls="faq2">
                                    How much will it cost?
                                </a>
                            </h4>
                        </div>
                        <div id="faq2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                            <div class="panel-body">
                                Price depends on your car, your location and the service you need. Since we don't have any overhead cost involved, you can save up to 30-40% of what you normally pay at a repair shop. Feel free to request a quote.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading3">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq3" aria-expanded="false" aria-controls="faq3">
                                    Are you promising me that I will always save money on my auto repairs?
                                </a>
                            </h4>
                        </div>
                        <div id="faq3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                            <div class="panel-body">
                                Since we value our customers so much, we only offer OE quality products for our repair. We offer 6 month/3,000 mile warranty on all parts & services we bring. When you buy your own parts, we cannot offer you the warranty.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq4" aria-expanded="false" aria-controls="faq4">
                                    How do I make an appointment?
                                </a>
                            </h4>
                        </div>
                        <div id="faq4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                            <div class="panel-body">
                                It's quite simple. Go to our website www.unclefitter.com or your mobile app, enter your vehicle information and the service needed. We will match you up with a mobile mechanic who will come to your home/office. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading5">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq5" aria-expanded="false" aria-controls="faq5">
                                    Is there a fee for the mechanic to diagnose my car?
                                </a>
                            </h4>
                        </div>
                        <div id="faq5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                            <div class="panel-body">
                                Yes, there is a fee for the mechanic to diagnose your car. This fee is GHC200. It includes everything from the inspection and diagnostic time to the cost of driving to your location.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading6">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq6" aria-expanded="false" aria-controls="faq6">
                                    What happens if additional repair is discovered?
                                </a>
                            </h4>
                        </div>
                        <div id="faq6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                            <div class="panel-body">
                                During the job, if the mechanics discover additional repairs to your vehicle, they can recommend the services required and we will get you a quote right away and can work on it at the earliest. However, if you choose not to get the repair done right away, the quote will be saved in your profile for your future reference.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading7">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq7" aria-expanded="false" aria-controls="faq7">
                                    What auto repair services do you offer?
                                </a>
                            </h4>
                        </div>
                        <div id="faq7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                            <div class="panel-body">
                                We do all the basic repair jobs from brakes and oil changes to starter, battery and timing belt replacement. However, we don't do jobs involving engine or transmission.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading8">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq8" aria-expanded="false" aria-controls="faq8">
                                    Where is your shop?
                                </a>
                            </h4>
                        </div>
                        <div id="faq8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                            <div class="panel-body">
                                Our mechanics are mobile. They come to your home or office. You can always find us at www.unclefitter.com or our mobile app.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading9">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq9" aria-expanded="false" aria-controls="faq9">
                                    What sort of vehicles do you work on?
                                </a>
                            </h4>
                        </div>
                        <div id="faq9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                            <div class="panel-body">
                                We have a huge database of vehicles from 2003 to 2017 on our website. Any work performed on these vehicles from our database may depend on the mechanic qualification. If our system cannot find a mechanic for your car's need, we will not be able to offer you a service. But the great news is we are expanding our mechanics' pool day by day. Soon we will be able to find someone to assist your needs.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading10">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq10" aria-expanded="false" aria-controls="faq10">
                                    What hours are you open?
                                </a>
                            </h4>
                        </div>
                        <div id="faq10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                            <div class="panel-body">
                                Our website, mobile apps are available 24/7. Our mechanics set the time they want to work. However, we work closely with the mechanics to have enough of them available between 7 am and 5 pm to serve you.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading11">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq11" aria-expanded="false" aria-controls="faq11">
                                    How long does it take to get services from UncleFitter?
                                </a>
                            </h4>
                        </div>
                        <div id="faq11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
                            <div class="panel-body">
                                For appointment involving parts, our mechanics are able to serve you immediately we are able to procure the genuine parts and this is usually after 24-72 hours. For services without parts, including diagnostics, you will able to get you a mechanic as early as 24 hours.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading12">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq12" aria-expanded="false" aria-controls="faq12">
                                    How long will it take for my car to be repaired?
                                </a>
                            </h4>
                        </div>
                        <div id="faq12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12">
                            <div class="panel-body">
                                Depending on the service, the mechanic can have the job done within an hour or two. Give the mechanics up to 30 minutes to setup and clean up. In all, it depends on the complexity of the job and the services required.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading13">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq13" aria-expanded="false" aria-controls="faq13">
                                    Where can I get my car repaired?
                                </a>
                            </h4>
                        </div>
                        <div id="faq13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13">
                            <div class="panel-body">
                                You can get your car repaired at the convenience of your home/office. However, due to safety concern for our mechanics, we don't offer any services in public parking lots or on side streets.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading14">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq14" aria-expanded="false" aria-controls="faq14">
                                    Do I get a rental car if I need one?
                                </a>
                            </h4>
                        </div>
                        <div id="faq14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
                            <div class="panel-body">
                                No, we currently don't offer this option.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading15">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq15" aria-expanded="false" aria-controls="faq15">
                                    Is there a cancellation fee?
                                </a>
                            </h4>
                        </div>
                        <div id="faq15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading15">
                            <div class="panel-body">
                                Even though we currently do not charge any cancellation fees. We encourage all cancellations 48 hours before the appointment time. Late cancellations may interrupt our mechanics timing structure.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading16">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq16" aria-expanded="false" aria-controls="faq16">
                                    Which cities do you serve?
                                </a>
                            </h4>
                        </div>
                        <div id="faq16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading16">
                            <div class="panel-body">
                                We are currently serving Accra. But kep your fingers crossed, we expand to other cities soon.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading17">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq17" aria-expanded="false" aria-controls="faq17">
                                    Who are the mechanics at UncleFitter?
                                </a>
                            </h4>
                        </div>
                        <div id="faq17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading17">
                            <div class="panel-body">
                                Our mechanics are professionals with years of industry experience. Most of them are currently working at a dealership or repair shops and choose to earn some money on the side.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading18">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq18" aria-expanded="false" aria-controls="faq18">
                                    What types of experience do the mechanics have?
                                </a>
                            </h4>
                        </div>
                        <div id="faq18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading18">
                            <div class="panel-body">
                                We hire mechanics with 5 years or more of industrial experience. Most of our mechanics have more than 10 years of experience and auto technician certifications.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading19">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq19" aria-expanded="false" aria-controls="faq19">
                                    Do I have the option to choose a mechanic of my choice?
                                </a>
                            </h4>
                        </div>
                        <div id="faq19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading19">
                            <div class="panel-body">
                                Our system is designed to consider a mechanic's availability, skills & location before they are assigned to a job. For this reason, you won't be able to select your own mechanic. We are sure you don't want a mechanic to show-up and don't know how to fix the problem.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading20">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq20" aria-expanded="false" aria-controls="faq20">
                                    Does the mechanic offer a roadside assistance program?
                                </a>
                            </h4>
                        </div>
                        <div id="faq20" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading20">
                            <div class="panel-body">
                                No. Due to the safety concerns for our mechanics, we don't offer repair services in public parking lots and roadsides.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading21">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq21" aria-expanded="false" aria-controls="faq21">
                                    Am I supposed to tip the mechanic?
                                </a>
                            </h4>
                        </div>
                        <div id="faq21" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading21">
                            <div class="panel-body">
                                It's not necessary or expected. The biggest tip they can receive is your rating and feedback you provide on their profile.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading22">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq22" aria-expanded="false" aria-controls="faq22">
                                    What do I do if the mechanic is not so cooperative?
                                </a>
                            </h4>
                        </div>
                        <div id="faq22" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading22">
                            <div class="panel-body">
                                Our number aim is to 'Make Customers Happy'. If you are not satisfied with the mechanic's service, you always have the option to rate him and you may also call the customer service number. We require our mechanics' to maintain a very high satisfaction rate to be in our network.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading23">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq23" aria-expanded="false" aria-controls="faq23">
                                    How are the mechanics vetted?
                                </a>
                            </h4>
                        </div>
                        <div id="faq23" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading23">
                            <div class="panel-body">
                                After the mechanics send in their application, we do a complete background check, certificate validation(if required) and reference check. Then we have a one on one interview with the mechanic(a practical and written test). Once, the mechanics join our team, they are assigned to work with our customers. Our customers have the ability to rate the services these mechanics offer. If the customers don't give the mechanic a good rating, they are automatically dropped from our system.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading24">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq24" aria-expanded="false" aria-controls="faq24">
                                    How is the price calculated?
                                </a>
                            </h4>
                        </div>
                        <div id="faq24" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading24">
                            <div class="panel-body">
                                Our prices are inclusive of the parts and labour. We provide parts at a retail price and calculate the labour based on the complexity and time required to complete the job. this is usually based on the car model and year.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading25">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq25" aria-expanded="false" aria-controls="faq25">
                                    How do I request a quote if I don't know what is wrong with my car?
                                </a>
                            </h4>
                        </div>
                        <div id="faq25" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading25">
                            <div class="panel-body">
                                If you are not sure what is wrong with your car, you can always contact our customer service center at +233504970929. One of our agents would be more than happy to assist you. We can have a mechanic sent to your location and run a diagnostic test and provide you with an inspection report regarding your car's status. They will also provide you a quote with recommendations of what needs to be fixed and their costs.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading26">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq26" aria-expanded="false" aria-controls="faq26">
                                    Is there an additional fee for the mechanic to come to my location?
                                </a>
                            </h4>
                        </div>
                        <div id="faq26" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading26">
                            <div class="panel-body">
                                There is no additional charge for the mechanic to come to your location. However, if you require a diagnostic test to be run, there is a fee associated with it. This fee is waived if you choose to take the service that is recommended by the mechanic.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading27">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq27" aria-expanded="false" aria-controls="faq27">
                                    Can I use UncleFitter if my car has warranty?
                                </a>
                            </h4>
                        </div>
                        <div id="faq27" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading27">
                            <div class="panel-body">
                                Manufacturer's warranty is done through the dealerships. We cannot offer services that are covered by this warranty. Same applies for extended service plan as well. However most warranties don't cover normal wear and tear such as brakes, belts, oils etc. You can use UncleFitter to save money for those services.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading28">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq28" aria-expanded="false" aria-controls="faq28">
                                    Is payment information required to book an appointment?
                                </a>
                            </h4>
                        </div>
                        <div id="faq28" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading28">
                            <div class="panel-body">
                                No, payment information is not required to make an appointment. However, if you choose to pay by mobile money or your card. You can do that via ExpressPay on our website or mobile apps.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading29">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq29" aria-expanded="false" aria-controls="faq29">
                                    My car just broke down. Can I get a mechanic instantly?
                                </a>
                            </h4>
                        </div>
                        <div id="faq29" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading29">
                            <div class="panel-body">
                                No, we currently do not offer recovery or emergency services. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading30">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq30" aria-expanded="false" aria-controls="faq30">
                                    How can I reschedule an appointment?
                                </a>
                            </h4>
                        </div>
                        <div id="faq30" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading30">
                            <div class="panel-body">
                                Select your appointment and click 'ReSchedule'. You will be able to select a new time. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading31">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq31" aria-expanded="false" aria-controls="faq31">
                                    What if the mechanic is late?
                                </a>
                            </h4>
                        </div>
                        <div id="faq31" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading31">
                            <div class="panel-body">
                                Our mechanics wants to offer you the best car repair experience possible. However, different variables like traffic, unexpected delays from another job can affect this experience. Our mechanics will try their highest level to keep the appointment. They will contact you in case of emergencies. If they are not at your location, within 30 minutes of the scheduled appointment, feel free to call the mechanic directly or call us at +233504970292. We can sort out the situation and even reschedule the appointment for you if necessary.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading32">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq32" aria-expanded="false" aria-controls="faq32">
                                    Do you ever use remanufactured or used parts?
                                </a>
                            </h4>
                        </div>
                        <div id="faq32" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading32">
                            <div class="panel-body">
                                No we NEVER use used parts. However, on certain services like starter replacements or alternator replacements, new parts are hard to come by. In such circumstances, we use remanufactured parts that also comes with our standard warranty. This is a common practice in the industry.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading33">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq33" aria-expanded="false" aria-controls="faq33">
                                    Where are the parts coming from?
                                </a>
                            </h4>
                        </div>
                        <div id="faq33" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading33">
                            <div class="panel-body">
                                We work directly with parts supplied by reputed auto parts suppliers to pass the savings on to our customers. No more shady deals like what you see at dealerships and shops.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading34">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq34" aria-expanded="false" aria-controls="faq34">
                                    If I bring my own parts in, can you still work on my car?
                                </a>
                            </h4>
                        </div>
                        <div id="faq34" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading34">
                            <div class="panel-body">
                                Yes, we will only charge you for the labor in that case. If you are using your own parts, then the warranty will be voided for that service. Also, please make sure you are buying the right part as part numbers may vary even for the same car year and model.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading35">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq35" aria-expanded="false" aria-controls="faq35">
                                    Do the mechanics keep the parts they removed?
                                </a>
                            </h4>
                        </div>
                        <div id="faq35" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading35">
                            <div class="panel-body">
                                We always offer the customer the option to keep the old parts. If part is considered hazardous waste, our mechanics would notify you as it's given to you. Parts are your property, so broken or not, you're entitled to them.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading36">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq36" aria-expanded="false" aria-controls="faq36">
                                    Where can I find my receipt?
                                </a>
                            </h4>
                        </div>
                        <div id="faq36" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading36">
                            <div class="panel-body">
                                You will be emailed a copy of the receipt and service report after the mechanic has repaired your vehicle. You can also get it by accessing your account online at www.unclefitter.com or the mobile app.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading37">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq37" aria-expanded="false" aria-controls="faq37">
                                    How do I pay for the service?
                                </a>
                            </h4>
                        </div>
                        <div id="faq37" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading37">
                            <div class="panel-body">
                                You can pay for the service using mobile money, your credit /debit card or pay cash to the mechanic on site. You are required to choose payment method at the time of your appointment. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading38">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq38" aria-expanded="false" aria-controls="faq38">
                                    Can I pay by check?
                                </a>
                            </h4>
                        </div>
                        <div id="faq38" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading38">
                            <div class="panel-body">
                                No. Due to security reasons, we cannot accept checks.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading39">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq39" aria-expanded="false" aria-controls="faq39">
                                    How can I resolve my billing issues?
                                </a>
                            </h4>
                        </div>
                        <div id="faq39" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading39">
                            <div class="panel-body">
                                We offer straightforward pricing without any last minute surprises. However, if you stumble across any issues with your bill, send an email to accts@unclefitter.com or call us at +233504970929. Please provide us your account information when you contact us.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading40">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq40" aria-expanded="false" aria-controls="faq40">
                                    Is there a warranty for your service?
                                </a>
                            </h4>
                        </div>
                        <div id="faq40" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading40">
                            <div class="panel-body">
                                Every service offered by the mechanics through UncleFitter comes with a 6-month/ 3,000 mile warranty. The same is only true for the parts bought through us.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading41">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq41" aria-expanded="false" aria-controls="faq41">
                                    How can I file a claim under this warranty?
                                </a>
                            </h4>
                        </div>
                        <div id="faq41" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading41">
                            <div class="panel-body">
                                If you wish to file a claim under the warranty, please do so within the time period of the warranty. You can also give us a call at +233504970929 regarding any concerns that you may have.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading42">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq42" aria-expanded="false" aria-controls="faq42">
                                    How does the used car inspection service work?
                                </a>
                            </h4>
                        </div>
                        <div id="faq42" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading42">
                            <div class="panel-body">
                                It's an inspection service where you can have a mechanic check out the car you are about to purchase.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading43">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq43" aria-expanded="false" aria-controls="faq43">
                                    How do I make an appointment for a pre-purchase car inspection?
                                </a>
                            </h4>
                        </div>
                        <div id="faq43" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading43">
                            <div class="panel-body">
                                Just like any other service. Choose this service from our website/mobile app, choose the time and location and book it.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading44">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq44" aria-expanded="false" aria-controls="faq44">
                                    How detailed is this service?
                                </a>
                            </h4>
                        </div>
                        <div id="faq44" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading44">
                            <div class="panel-body">
                                The mechanic will perform a bumper to bumper thorough inspection of the car. As he does it, he will fill a report provided by us to standardize the service. He will even take pictures of any issues and include that in the report. Once the inspection is done, you will receive the report by email. You can also access the report later through your online account.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="panel-heading" role="tab" id="heading45">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq45" aria-expanded="false" aria-controls="faq45">
                                    Do I have to be present at the location?
                                </a>
                            </h4>
                        </div>
                        <div id="faq45" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading45">
                            <div class="panel-body">
                                It's up to you. If you wish not to be present during the inspection, make sure to enter the seller's contact info while making the appointment. The mechanic will contact the seller to perform the inspection. You will receive the inspection report.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid no-padding bg--color" id="more">
    @include('web/blocks/partials/how--we--help')
</div>
<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection