var sidenav = document.getElementById("sidenav");
var main = document.getElementById("main");
var openNav = document.getElementById("openNav");
var closeNav = document.getElementById("closeNav");
var overL = document.getElementById("overL");
var menu = document.getElementsByClassName("menu");
var dropdownbtn = document.getElementsByClassName("dropdown-btn");
var dropdownContainer = document.getElementsByClassName("dropdown-container");
var i;

// open sidenav
openNav.addEventListener("click", function() {
    var w = window.innerWidth;
    if (w < 800){
      main.style.marginLeft = "0";
      sidenav.style = "width: 210px; border-right: 1px solid #23282c";
    } else if (w > 800){
      main.style.marginLeft = "210px";
      sidenav.style = "width: 210px; border-right: 1px solid #23282c";
    }

    for (i = 0; i < menu.length; i++) {
        menu[i].style.display = "block";
    }
    for (i = 0; i < dropdownbtn.length; i++) {
        dropdownbtn[i].style.display = "block";
    }

    openNav.style.display = "none";
    closeNav.style.display = "block";
});

//close sidenav
closeNav.addEventListener("click", function() {

    main.style.marginLeft = "0";
    sidenav.style = "width: 0; border-right: 0";
    
    for (i = 0; i < menu.length; i++) {
        menu[i].style.display = "none";
    }
    for (i = 0; i < dropdownbtn.length; i++) {
        dropdownbtn[i].style.display = "none";
    }
    for (i = 0; i < dropdownContainer.length; i++) {
        dropdownContainer[i].style.display = "none";
    }

    openNav.style.display = "block";
    closeNav.style.display = "none";

});

// open close nav on window resize
document.getElementsByTagName("BODY")[0].onresize = function() {
  var w = window.innerWidth; 

  if (w < 800){
  
    main.style.marginLeft = "0";
    sidenav.style = "width: 0; border-right: 0";
    
    for (i = 0; i < menu.length; i++) {
        menu[i].style.display = "none";
    }
    for (i = 0; i < dropdownbtn.length; i++) {
        dropdownbtn[i].style.display = "none";
    }
    for (i = 0; i < dropdownContainer.length; i++) {
        dropdownContainer[i].style.display = "none";
    }

    openNav.style.display = "block";
    closeNav.style.display = "none";

    } else if (w > 800){
  
    main.style.marginLeft = "210px";
    sidenav.style = "width: 210px; border-right: 1px solid #23282c";
    
    for (i = 0; i < menu.length; i++) {
        menu[i].style.display = "block";
    }
    for (i = 0; i < dropdownbtn.length; i++) {
        dropdownbtn[i].style.display = "block";
    }

    openNav.style.display = "none";
    closeNav.style.display = "block";

    }
}

var dropdown = document.getElementsByClassName("dropdown-btn");


// open close dropdown
var dropdown = document.getElementsByClassName("dropdown-btn");

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
