<?php
  if($is_front){
     $page['content']['system_main']['default_message'] = array(); // This will remove the 'No front page content has been created yet.'
  }
?>

<div class="main-container <?php print $container_class; ?>">

<div class="row visible-xs">
    <div class="navbar mobilenav" role="navigation">
        <div class="navbar-header">
          <button data-target=".tb-mega-collapse" data-toggle="collapse" class="btn btn-navbar tb-megamenu-button menuIstance-processed navbar-toggle" type="button">
            <i class="fa fa-reorder"></i>
          </button>
          <button class="navbar-toggle" data-target="#collapse-quicklinks" data-toggle="collapse" title="Quick Links" type="button">
              <span class="sr-only">Toggle Quick Links Navigation</span>
              <span class="glyphicon glyphicon-link" ></span>
            </button>
            <button class="navbar-toggle" data-target="#collapse-search" data-toggle="collapse" title="NIUDL Collection Search" type="button">
              <span class="sr-only">Toggle NIUDL Collection Search</span>
              <span class="glyphicon glyphicon-search" ></span>
            </button>
        </div>
    </div>
</div>

<header class="row banner">
  <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12" id="logo">
    <p style="text-align: center;">
      <span class="logo-head">Nickels and Dimes</span>
      <br>
      <span class="logo-sub">From the Collections of Johannsen and LeBlanc</span>
    </p>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
      <ul class="nav navbar-nav navbar-right global visible-lg visible-md visible-sm">
        <li><a href="http://www.niu.edu/web.shtml" onclick="ga('send','event','Exit Points','Global Nav','A-Z');"><span class="glyphicon glyphicon-list-alt"></span> <small>A-Z Index</small></a></li>
	    <li><a href="https://directory.niu.edu/app/directory/PeopleSearch.aspx" onclick="ga('send','event','Exit Points','Global Nav','Directory');"><span class="glyphicon glyphicon-user"></span> <small>Directory</small></a></li>
        <li><a href="https://calendar.niu.edu/" onclick="ga('send','event','Exit Points','Global Nav','Calendar');"><span class="glyphicon glyphicon-calendar"></span> <small>Calendar</small></a></li>
        <li><a href="http://www.ulib.niu.edu/" onclick="ga('send','event','Exit Points','Global Nav','Libraries');"><span class="glyphicon glyphicon-book"></span> <small>Libraries</small></a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-link"></span> <small>Quick Links</small><span class="caret"></span></a>
          <ul class="dropdown-menu quicklinks" role="menu">
            <li><a href="https://webcourses.niu.edu/" onclick="ga('send','event','Exit Points','Quick Links','Blackboard');" target="new">Blackboard</a></li>
            <li><a href="https://myniu.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','My NIU');" target="new">My NIU</a></li>
            <li><a href="https://mapworks.skyfactor.com/" onclick="ga('send','event','Exit Points','Quick Links','Mapworks');" target="new">Mapworks</a></li>
            <li><a href="https://niu.collegiatelink.net/account/logon" onclick="ga('send','event','Exit Points','Quick Links','Huskie Link');" target="new">Huskie Link</a></li>
            <li><a href="https://o365.niu.edu/" onclick="ga('send','event','Exit Points','Quick Links','Office 365');" target="new">Office 365</a></li>
            <li><a href="https://anywhereapps.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','Anywhere Apps');" target="new">Anywhere Apps</a></li>
            <li><a href="https://niu.qualtrics.com" onclick="ga('send','event','Exit Points','Quick Links','Qualtrics');" target="new">Qualtrics</a></li>
            <li><a href="http://niu.edu/careerservices/huskiesgethired/index.shtml" onclick="ga('send','event','Exit Points','Quick Links','Huskies Get Hired');" target="new">Huskies Get Hired</a></li>
            <li><a href="http://webmail.students.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','Student Email');">Student Email</a></li>
            <li><a href="http://password.niu.edu/" onclick="ga('send','event','Exit Points','Quick Links','Password Self Service');" target="new">Password Self-Service</a></li>
          </ul>
        </li>
      </ul>
<!-- global menu for smartphone-->
      <div class="col-xs-12 visible-xs">
        <ul class="col-xs-12 nav nav-list globalmobile">
          <li><a href="web.shtml" onclick="ga('send','event','Exit Points','Global Nav','A-Z');"><span class="glyphicon glyphicon-list-alt"></span> <small>A-Z</small></a></li>
          <li><a href="https://directory.niu.edu/" onclick="ga('send','event','Exit Points','Global Nav','Directory');"><span class="glyphicon glyphicon-user"></span> <small>Directory</small></a></li>
          <li><a href="https://calendar.niu.edu/" onclick="ga('send','event','Exit Points','Global Nav','Calendar');"><span class="glyphicon glyphicon-calendar"></span> <small>Calendar</small></a></li>
          <li><a href="http://www.ulib.niu.edu/" onclick="ga('send','event','Exit Points','Global Nav','Libraries');"><span class="glyphicon glyphicon-book"></span><small> Libraries</small></a></li>
        </ul>
      </div>
      <div class="col-xs-12 visible-xs">
        <div class="collapse" id="collapse-search">
          <?php if (!empty($page['header'])): ?>
            <?php print render($page['header']); ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="visible-lg visible-md visible-sm">
        <div class="row" id="collapse-search">
          <?php if (!empty($page['header'])): ?>
            <?php print render($page['header']); ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-xs-12 visible-xs">
        <div class="collapse nav-collapse quicklinks" id="collapse-quicklinks">
          <ul class="quicklinks" role="menu">
            <li><span class="glyphicon glyphicon-link"></span><strong>Quick Links</strong></li>
            <ul>
              <li><a href="https://webcourses.niu.edu/" onclick="ga('send','event','Exit Points','Quick Links','Blackboard');" target="new">Blackboard</a></li>
              <li><a href="https://myniu.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','My NIU');" target="new">My NIU</a></li>
              <li><a href="https://mapworks.skyfactor.com" onclick="ga('send','event','Exit Points','Quick Links','Mapworks');" target="new">Mapworks</a></li>
              <li><a href="https://niu.collegiatelink.net/account/logon" onclick="ga('send','event','Exit Points','Quick Links','Huskie Link');" target="new">Huskie Link</a></li>
              <li><a href="http://niu.edu/careerservices/huskiesgethired/index.shtml" onclick="ga('send','event','Exit Points','Quick Links','Huskies Get Hired');" target="new">Huskies Get Hired</a></li>
            </ul>
            <ul>
              <li><a href="http://O365.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','Office 365');" target="new">Office 365</a></li>
              <li><a href="http://webmail.students.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','Student Email');">Student Email</a></li>                
              <li><a href="https://anywhereapps.niu.edu" onclick="ga('send','event','Exit Points','Quick Links','Anywhere Apps');" target="new">Anywhere Apps</a></li>
              <li><a href="https://niu.qualtrics.com" onclick="ga('send','event','Exit Points','Quick Links','Qualtrics');" target="new">Qualtrics</a></li>
              <li><a href="http://password.niu.edu/" onclick="ga('send','event','Exit Points','Quick Links','Password Self Service');" target="new">Password Self-Service</a></li>               
             </ul>
           </ul>
         </div>
       </div>
   </div>
</header>
<header id="navbar" role="menu" class="navbar-collapse collapse tb-mega-collapse">
    <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
          <?php if (!empty($primary_nav)): ?>
            <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
            <?php print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($page['navigation'])): ?>
            <?php print render($page['navigation']); ?>
          <?php endif; ?>
    <?php endif; ?>
</header>

  <div class="row">

    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>

    <section<?php print $content_column_class; ?> id="main-content">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>

  </div>
</div>

  <footer class="footer <?php print $container_class; ?>">
    <div class="col-lg-4 col-md-4 col-sm-4 col-lg-push-4 col-md-push-4 col-sm-push-4 niu-home"><!--Athletics and Social Columns-->
      <p><a href="http://www.niu.edu/" target="new"><img alt="NIU Logo" src="http://www.niu.edu/masterto/themes/Theme_1_0/css/theme_images/niu_logo.png" /></a></p>
      <p><a href="http://www.niu.edu/" target="new">NIU Home</a></p>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-lg-pull-4 col-md-pull-4 col-sm-pull-4 footer-about"><!--About Column-->
      <h3>NIU Links</h3>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <ul class="about-list">
            <li><a class="apply" href="http://www.niu.edu/apply/index.shtml" onclick="ga('send','event','Exit Points','Footer','Apply');">Apply to NIU</a></li>
            <li><a href="http://www.niu.edu/visit/index.shtml" onclick="ga('send','event','Exit Points','Footer','Visit Campus');">Visit Campus</a></li>
            <li><a href="http://www.niu.edu/visit/maps/" onclick="ga('send','event','Exit Points','Footer','Directions');">Directions/Maps</a></li>
            <li><a href="http://www.niu.edu/contactinfo.shtml" onclick="ga('send','event','Exit Points','Footer','Contact Info');">Contact Us</a></li>
          </ul>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <ul class="about-list">
            <li><a href="http://www.niu.edu/emergencyinfo/" onclick="ga('send','event','Exit Points','Footer','Emergency Info');">Emergency Information</a></li>
            <li><a href="http://www.niu.edu/accessibility.shtml" onclick="ga('send','event','Exit Points','Footer','Accessibility');">Accessibility</a></li>
            <li><a href="http://www.niu.edu/employment/" onclick="ga('send','event','Exit Points','Footer','Jobs');">Jobs @ NIU</a></li>
            <li><a href="http://www.niuhuskies.com">NIUHuskies.com</a></li>
          </ul>
        </div>
      </div>
    </div>
  <!-- End About Column-->
    <div class="col-lg-4 col-md-4 col-sm-4 address" style="margin-top: 1.65em;">
      <p>&#169;2016 Board of Trustees of<br /> <a href="http://www.niu.edu/">Northern Illinois University</a>.<br /> All rights reserved.<br /> <a href="http://doit.niu.edu/doit/policies/privacy_policy.shtml">Web Site Privacy Policy</a></p>
      <p>1425 W. Lincoln Hwy., DeKalb, IL 60115<br /> (815) 753-1000 | <a href="mailto:univinfo@niu.edu">univinfo@niu.edu</a></p>
    </div>
  </footer>

<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58126c9706fe4832"></script> 
