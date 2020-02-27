

<?php
    function page_content(){
    
    	global $co, $msg;
    
    	$co->page_title = "Search | 
    
    	LinkiBag";
    	$page = $co->query_first("SELECT * 
    
    		FROM pages WHERE page_id=:id ", array('id'=>4));
    	
    
    		?>	
<section class="search-box-page">
<div class="container">
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="search-categories">
            <a href="#">Education</a> <a href="#">Business</a> <a href="#"> Fun</a>
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div class="search-box-page text-center">
            <h2>
                <a href="#">thisisfeliks@gmail.com</a> 
                <sup>
                    <small> 
                    <span>
                        <a href="#">
                            Edit
						</a>	
                    </span>
                    </small>
                </sup>
            </h2>
            <form>
            <input type="email" class="form-control" id="email" value="University" placeholder="">
            <button type="submit" class="btn blue-bg">LinkiBag Search</button>
            </form>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
    <div class="search-active-categories">
    <p>Category: <span>Education</span></p>
    </div>
    </div>
    <div class="col-md-12 col-xs-12">
    <div class="search-results">
    <div class="row">
    <div class="col-md-3 col-xs-12">
    <div class="search-web-link">               
    <a href="#">www.uic.edu</a>
    </div>	
    </div>	
    <div class="col-md-9 col-xs-12">
    <div class="search-web-dis">  
    <p>Chicago 's Public Research <a href="#"> University ...</a> As Chicago's only Public Research University with 29,000 students,
    15 Colleges.</p>
    </div>
    </div>
    </div>
    </div>
    <div class="search-results">
    <div class="row">
    <div class="col-md-3 col-xs-12">
    <div class="search-web-link">               
    <a href="#">www.uic.edu</a>
    </div>	
    </div>	
    <div class="col-md-9 col-xs-12">
    <div class="search-web-dis">  
    <p>Chicago 's Public Research <a href="#"> University ...</a> As Chicago's only Public Research University with 29,000 students,
    15 Colleges.</p>
    </div>
    </div>
    </div>
    </div>
    <div class="search-results">
    <div class="row">
    <div class="col-md-3 col-xs-12">
    <div class="search-web-link">               
    <a href="#">www.uic.edu</a>
    </div>	
    </div>	
    <div class="col-md-9 col-xs-12">
    <div class="search-web-dis">  
    <p>Chicago 's Public Research <a href="#"> University ...</a> As Chicago's only Public Research University with 29,000 students,
    15 Colleges.</p>
    </div>
    </div>
    </div>
    </div>
    </div>
	</div>
</div>
</section>	
<?php
}
?>	
<style>

.search-categories a {
    border-bottom: 1px solid;
    color: #7f7f7f;
    margin: 0 22px 0 0;
}
.search-box-page input {
    border: 1px solid #7f7f7f !important;
    border-radius: 0;
    box-shadow: none !important;
    color: #004080;
    font-size: 17px;
    height: auto;
    margin: 40px 0 27px;
    padding: 6px 15px;
}
.search-box-page .btn {
    background: #31496a none repeat scroll 0 0;
    border-radius: 0;
    color: #fff !important;
    font-size: 17px;
    font-weight: bold;
    padding: 3px 34px;
}
.search-box-page h2 a {
    color: #ff7f27 !important;
    font-weight: normal;
}
.search-box-page h2 {
    margin: -4px 0 0;
}
.search-box-page h2 sup a {
    border-bottom: 1px solid;
    color: #7f7f7f !important;
}

.search-results a, .search-results p {
    color: #7f7f7f;
    font-size: 18px;
}
.search-web-link a {
    border-bottom: 1px solid;
}
.search-web-dis a {
    color: #004080;
}
.search-results {
    margin: 0 0 20px;
}
.search-active-categories p {
    color: #7f7f7f;
    font-size: 18px;
}
.search-active-categories {
    margin: 0 0 39px;
}

</style>

