//enable disable input on change
function RequiredV(){
    var exp = document.getElementById('expmode').value;
    var val = document.getElementById('validity').style;
    var grp = document.getElementById('graceperiod').style;
    var vali = document.getElementById('validi');
    var grpi = document.getElementById('gracepi');
    if (exp === 'rem' || exp === 'remc') {
      val.display= 'table-row';
      vali.type = 'text';
      if (vali.value === "") {
        vali.value = "";
      }
      $("#validi").focus();
      grp.display = 'table-row';
      grpi.type = 'text';
      if (grpi.value === "") {
        grpi.value = "5m";
      }
    } else if (exp === 'ntf' || exp === 'ntfc') {
      val.display= 'table-row';
      vali.type = 'text';
      if (vali.value === "") {
        vali.value = "";
      }
      $("#validi").focus();
      grp.display = 'none';
      grpi.type = 'hidden';
    } else {
      val.display = 'none';
      grp.display = 'none';
      vali.type = 'hidden';
      grpi.type = 'hidden';
    }
}


// default user length
function defUserl(){
   var usr = document.getElementById('user').value;
   var num = document.getElementById('num').style;
   var lower = document.getElementById('lower').style;
   var upper = document.getElementById('upper').style;
   var upplow = document.getElementById('upplow').style;
   var lower1 = document.getElementById('lower1').style;
   var upper1 = document.getElementById('upper1').style;
   var upplow1 = document.getElementById('upplow1').style;
   var mix = document.getElementById('mix').style;
   var mix1 = document.getElementById('mix1').style;
   var mix2 = document.getElementById('mix2').style;
  if(usr === 'up'){
     $('select[name=userl] option:first').html('4');
     $('select[name=char] option:first').html('abcd');
     lower.display = 'block';
     upper.display = 'block';
     upplow.display = 'block';
     lower1.display = 'none';
     upper1.display = 'none';
     upplow1.display = 'none';
     num.display = 'none';
     mix.display = 'block';
     mix1.display = 'block';
     mix2.display = 'block';
  }else if(usr === 'vc'){
    $('select[name=userl] option:first').html('8');
    $('select[name=char] option:first').html('abcd1234');
    lower.display = 'none';
    upper.display = 'none';
    upplow.display = 'none';
    lower1.display = 'block';
    upper1.display = 'block';
    upplow1.display = 'block';
    num.display = 'block';
    mix.display = 'block';
    mix1.display = 'block';
    mix2.display = 'block';
}}


  