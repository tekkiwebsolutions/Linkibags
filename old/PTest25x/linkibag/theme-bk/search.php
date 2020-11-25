<?php

function page_content(){

	global $co, $msg;

	$co->page_title = "Search | 

	LinkiBag";
	$page = $co->query_first("SELECT * 

		FROM pages WHERE page_id=:id ", array('id'=>4));
	

		?>	

		<section class="public-bag">
			<div class="container">		
				<div class="col-md-4 col-xs-12 lst">
					<ul>               
						<li><u><a href="#">Education</a></u></li>
						<li><u><a href="#">Business</a></u></li>
						<li><u><a href="#"> Fun</a></u></li>                   
					</ul>
				</div>		

				<div class="col-md-6 col-xs-12 left">
					<h2><a href="#">thisisfeliks@gmail.com</a> <sup><small> <span><a href="#">Edit</span> <small></sup> </h2>
					<div class="col-md-8-col-offset-2 form-group">
						 <input type="email" class="form-control" id="email" placeholder="starbucks">
					</div>
					<button type="button" class="btn btn-primary active">LinkiBag Search</button>
				</div>
				<div class="col-md-2"></div>
				<div class="blue-border"></div>
			</div>
		</section>

	

	<!-- 	<section class="public-bag">

			<div class="container lines">
				<div class="col-md-3 col-xs-12 link">
					<ul>               
						<li><u><a href="#">www.uic.edu</a></u></li>
					</ul>	
				</div>	

				<div class="col-md-9 col-xs-12 chicago">
					<p>Chicago 's Public Research <a href="#"> University ...</a> As Chicago's only Public Research University with 29,000 students,
						15 Colleges.</p>
					</div>
				</div>

			</section>

			<section class="public-bag">

				<div class="container lines">
					<div class="col-md-3 col-xs-12 link">
						<ul>               
							<li><u><a href="#">www.uic.edu:</a></u></li>
						</ul>	
					</div>	

					<div class="col-md-9 col-xs-12 chicago">
						<p>Chicago 's Public Research <a href="#"> University ...</a> As Chicago's only Public Research University with 29,000 students,
							15 Colleges.</p>
						</div>
					</div>
				</section> -->

				<?php

			}

			?>	


			<style>
			.public-bag ul li {display: inline;padding-left: 35px;}
			.left h2 {text-align: center;font-size: 27px;font-weight: 500;}
			.form-group {text-align: center;}
			.left {text-align: center;}
			.left h2 {color: #f3580f;}
			.lines {font-size: 19px;color: grey;}
            .link ul li a {font-size: 19px;}
            .left span {color: grey;font-size: 18px}
            .public-bag {padding-top: 25px; padding-bottom: 15px;}
            .public-bag ul li a {color: grey;}
            .left h2 a {color: #FF7F27;}
   .public-bag {padding-top: 25px; padding-bottom: 270px;}
            .chicago {text-align: justify;}
            .small {color: grey;}
            .left h2 sup {color: grey;}            

            @media only screen and (max-width: 320px) {
           .public-bag ul li {
                                display: inline;
                                padding-left: 2px;
                              }

             .left h2 a {font-size: 18px;}                  
                        
               }
			</style>