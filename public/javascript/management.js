$(document).ready(function () {
   $("#Management_function").change(function () {
       var URL = window.location.host;
       window.location="http://"+URL+"/management/"+$("#Management_function").val();
   });
});