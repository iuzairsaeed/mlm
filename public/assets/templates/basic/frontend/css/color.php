<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}

function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>

.text-theme{
    color: <?php echo $color ?> !important;
}
.custom-button.theme, .theme-button, .video-button::before, .video-button::after, .video-button, .how-item .how-thumb, .faq-item.open .faq-title, .scrollToTop, .pagination .page-item a, .pagination .page-item span, .contact-form-group button, .support-search button, .btn--info{
    background: <?php echo $color ?>;
}

.menu li .submenu li:hover > a, .contact__item:hover .contact__icon, .header-wrapper .list li.selected.focus{
	background: <?php echo $color ?>;
}

.header-wrapper .list li:hover {
    background: <?php echo $color ?> !important;
}

.contact-form-group .select-item .list li.selected.focus, .contact-form-group .select-bar .list li.selected.focus {
    background: <?php echo $color ?>;
}

.contact-form-group .select-item .list li:hover,.contact-form-group .select-bar .list li:hover {
    background: <?php echo $color ?> !important;
}


.custom-button.theme {
    border-color: <?php echo $color ?>;
}

.counter-item .counter-thumb i, .plan-item .plan-header .icon, .footer-bottom p a, .dashboard-item .dashboard-content .amount, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a, .post-item:hover .post-content .blog-header .title a, .widget.widget-post ul li .content .sub-title a:hover, .contact__item .contact__icon, .contact__item .contact__body a, .breadcrumb li a:hover{
    color: <?php echo $color ?>;
}
.counter-item .counter-thumb i {
    border-bottom: 1px solid <?php echo $color ?>;
}
.custom--btn, .custom--badge, .custom--table {
    background-color: <?php echo $color ?> !important;
}
.counter-item .counter-content .title, .feature-item .feature-content .title{
	color: <?php echo $secondColor ?>;
}

.feature-item {
    border: 3px solid <?php echo $secondColor ?>33;
}

.deposit-table thead tr, .plan-item {
    background: <?php echo $secondColor ?>;
}






