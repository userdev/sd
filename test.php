
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="ddaccordion.js">


</script>

<script type="text/javascript">

ddaccordion.init({
	headerclass: "headerbar", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "mouseover", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

</script>

<style type="text/css">

.urbangreymenu{
width: 190px; /*width of menu*/
}

.urbangreymenu .headerbar{
   
font: bold 13px Verdana;
color: white;
background: #606060 url(arrowstop.gif) no-repeat 8px 6px; /*last 2 values are the x and y coordinates of bullet image*/
margin-bottom: 0; /*bottom spacing between header and rest of content*/
text-transform: uppercase;
padding: 7px 0 7px 31px; /*31px is left indentation of header text*/
}

.urbangreymenu .headerbar a{
text-decoration: none;
color: white;
display: block;
}

.urbangreymenu ul{
list-style-type: none;
margin: 0;
padding: 0;
margin-bottom: 0; /*bottom spacing between each UL and rest of content*/
}

.urbangreymenu ul li{
padding-bottom: 2px; /*bottom spacing between menu items*/
}

.urbangreymenu ul li a{
font: normal 12px Arial;
color: black;
background: #E9E9E9;
display: block;
padding: 5px 0;
line-height: 17px;
padding-left: 8px; /*link text is indented 8px*/
text-decoration: none;
}

.urbangreymenu ul li a:visited{
color: black;
}

.urbangreymenu ul li a:hover{ /*hover state CSS*/
color: white;
background: black;
}

</style>

<body>

<div class="urbangreymenu">

<h3 class="headerbar"><a href="http://www.dynamicdrive.com/style/">CSS Library</a></h3>
<ul class="submenu">
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C1/">Horizontal CSS Menus</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C2/">Vertical CSS Menus</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C4/">Image CSS</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C6/">Form CSS</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C5/">DIVs and containers</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C7/">Links & Buttons</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C8/">Other</a></li>
<li><a href="http://www.dynamicdrive.com/style/csslibrary/all/">Browse All</a></li>
</ul>

<h3 class="headerbar"><a href="http://www.javascriptkit.com">JavaScript Kit</a></h3>
<ul class="submenu">
<li><a href="http://www.javascriptkit.com/cutpastejava.shtml" >Free JavaScripts</a></li>
<li><a href="http://www.javascriptkit.com/javatutors/">JavaScript tutorials</a></li>
<li><a href="http://www.javascriptkit.com/jsref/">JavaScript Reference</a></li>
<li><a href="http://www.javascriptkit.com/dhtmltutors/">DHTML & CSS</a></li>
<li><a href="http://www.javascriptkit.com/howto/">Web Design</a></li>
<li><a href="http://www.javascriptkit.com/java/">Free Java Applets</a></li>		
</ul>

</div>

</body>

</html>