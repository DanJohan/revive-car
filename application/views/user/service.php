<!doctype html>
<html>
<head>

<title>Login-form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>public/userlogin/css/bootstrap.min.css">
  <link href="<?php echo base_url();?>public/userlogin/css/style.css" rel="stylesheet">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>   
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>  
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>  
 
  <script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</head>

<body id="dash">
<!--========TOP-BAR=========-->
<section class="top_bar">
  <div class="container">
     <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
	   <span class="email"><a href="#">Email: contact@reviveauto.in</a> <a href="#">Phone: +971 52 606 0881 </a></span>
	   </div>
	   <div class="col-md-6 col-sm-6 col-xs-12">
	   <div class="right_side">
	      <span class="lo_gin"><img src="<?php echo base_url();?>public/userlogin/img/6.jpg"></span>
	     <div class="btn-group show-on-hover">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
		</div>
      </div>
    </div>
	 </div>
  </div>
</section>
<!--========TOP-BAR-/=========-->

<!--========TOP-NAV=========-->
<section>
      <nav class="navbar navbar-expand-lg navbar-light bg-info">
	    <div class="custom_nav">
		<a class="navbar-brand1"><img src="<?php echo base_url();?>public/userlogin/img/logo.png" alt="Logo"></a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Enquiry</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
        </ul>
      </div>
	  </div>
    </nav>
</section>
<!--========TOP-NAV-/=========-->

<section>
  <div class="container">
    <div class="row">
	<div class="cn_diver">
	
	  <div class="col-sm-12 col-md-12 col-xs-12">
	  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012/12/02</td>
                <td>$372,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012/08/06</td>
                <td>$137,500</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010/10/14</td>
                <td>$327,900</td>
            </tr>
            <tr>
                <td>Colleen Hurst</td>
                <td>Javascript Developer</td>
                <td>San Francisco</td>
                <td>39</td>
                <td>2009/09/15</td>
                <td>$205,500</td>
            </tr>
            <tr>
                <td>Sonya Frost</td>
                <td>Software Engineer</td>
                <td>Edinburgh</td>
                <td>23</td>
                <td>2008/12/13</td>
                <td>$103,600</td>
            </tr>
            
            <tr>
                <td>Bradley Greer</td>
                <td>Software Engineer</td>
                <td>London</td>
                <td>41</td>
                <td>2012/10/13</td>
                <td>$132,000</td>
            </tr>
            <tr>
                <td>Dai Rios</td>
                <td>Personnel Lead</td>
                <td>Edinburgh</td>
                <td>35</td>
                <td>2012/09/26</td>
                <td>$217,500</td>
            </tr>
            <tr>
                <td>Jenette Caldwell</td>
                <td>Development Lead</td>
                <td>New York</td>
                <td>30</td>
                <td>2011/09/03</td>
                <td>$345,000</td>
            </tr>
            <tr>
                <td>Yuri Berry</td>
                <td>Chief Marketing Officer (CMO)</td>
                <td>New York</td>
                <td>40</td>
                <td>2009/06/25</td>
                <td>$675,000</td>
            </tr>
            <tr>
                <td>Caesar Vance</td>
                <td>Pre-Sales Support</td>
                <td>New York</td>
                <td>21</td>
                <td>2011/12/12</td>
                <td>$106,450</td>
            </tr>
           
        </tbody>
       
    </table>
	   </div>
	 </div>
	</div>
  </div>
</section>

  <script src="<?php echo base_url();?>public/userlogin/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>public/userlogin/js/bootstrap.min.js"></script>
</body>
</html>
