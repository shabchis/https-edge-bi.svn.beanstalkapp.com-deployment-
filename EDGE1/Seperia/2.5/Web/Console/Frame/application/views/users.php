<script id="userstmpl"  type="text/x-jquery-tmpl">
    	{{if Name}}
	    	<h2 class="usertrigger" data-user="${UserID}"><span> ${Name}</span><img class="x" src="assets/img/delete-icon.png"/></h2>
        {{/if}}

</script>
<script id="groupNameTmpl"  type="text/x-jquery-tmpl">

		{{if Name}}

            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="${Name}" />

       {{/if}}

</script>
<script id="groupstmpl"  type="text/x-jquery-tmpl">
		<option value="${GroupID}">${Name}</option>
</script>
<script id="generaltmpl" type="text/x-jquery-tmpl">
            <p class="email">
	    	<label for="email">Email</label>
			<input type="text" name="email" id="email" value="${Email}"/>
            </p>

</script>
<script id="usersgrouptmpl"  type="text/x-jquery-tmpl">

		<li id='${GroupID}'>${Name}</li>

</script>
<script id="accounttmpltest"  type="text/x-jquery-tmpl">
              {{if Name }}
         			 <option  id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
             	{{if ChildAccounts !=""}}
                	 {{each ChildAccounts}}
                  	  <option style="padding-left:40px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                        {{if ChildAccounts !=""}}
                            {{each ChildAccounts}}
                                <option style="padding-left:60px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option style="padding-left:80px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                     {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option style="padding-left:100px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                                           {{/each}}
                                  {{/if}}
                                {{/each}}
                                  {{/if}}
                                {{/each}}
                          {{/if}}
						{{/each}}
                {{/if}}
         {{/if}}
</script>
<div id="usertabs">
    <ul>
            <li><a href="#tabs-1">General</a></li>
            <li><a href="#tabs-2">Groups</a></li>
            <li><a href="#tabs-3">Permissions</a></li>
     	</ul>
	<div id="tabs-1">
       <form class="form" action="">

        <p class="name">

		    <label for="name">Name</label>
		       <input type="text" name="name" id="name" />
        </p>
   	   <p class="email">

	    	<label>Email</label>
			<input type="text" name="email" id="email" value=""/>
            </p>

          <p class="enable">
        	<label for="checkbox">Enable</label>
		<input type="checkbox" name="checkbox" id="checkbox"/>
	      </p>


</form>

</div>
<div id="tabs-2">
	      	<div id="addselecteduser">
				<select>
				</select>
		    <a id="add" href="#">Add</a>
		</div>
		<div class="clear"></div>
		<div id="userlist">
		<ul id="userlistings">


		</ul>

		</div>
		</div>
<div id="tabs-3">
		<div id="accountwrap">


		<div id="accountscombo">
            <select>
             </select>

		</div>

		</div>
		<div class="clear"></div>
		<div id="permissions">

		</div>
         <div class="overlay">
           <div id="msg">
             You must save changes before you can edit permissions.

              </div>
           </div>
	     </div>
</div>


<div id="userwrapper">
	<div id="usercontent">
	<div class="header">
			Name
  </div>
</div>
</div>

<script type="text/javascript">
var userId ;
var globalUsers = "";
var groupID = "";
var globalID = "";
var changed = false;
  var saved= false;
$(function(){

var users = jQuery.parseJSON('<?php echo $users; ?>');
	var groups = jQuery.parseJSON('<?php echo $groups; ?>');
     globalGroups =   groups;
   $('#userlistings').empty();
	$("#userstmpl").tmpl(users).appendTo("#usercontent");

  $("a#add").click(function(){


	var selected =$('#addselecteduser select option:selected');
	var selectedID =$('#addselecteduser select option:selected').val();


	$('#userlistings').append('<li id='+selectedID+'>'+selected.text()+'</li>');

	selected.remove();

      if($('#addselecteduser select').length == 0) {
         $("#addselecteduser select") = "list empty";
      }
    $('.ui-dialog-buttonpane button:last').show();
   $("div.overlay").show();
	return false;
});

$('#userlistings li').live('click',function(){

	$('#addselecteduser select').append('<option value='+$(this).attr('id')+'>'+$(this).text()+'</option>');

	$(this).fadeOut(2000).remove();
        $('.ui-dialog-buttonpane button:last').show();
       $("div.overlay").show();


});
    /*
   $("#permissions ul li.rep").each(function(){
        if($(this).hasClass('v')){
      $(this).removeClass('v').addClass("question").css('list-style-image','url("./assets/img/question.png")' )   ;
    }
    else if($(this).hasClass('-')) {

      $(this).removeClass('-').addClass("question").next('li').css('list-style-image','url("./assets/img/question.png") ')    ;
    }

     });
     */
$("#permissions ul li.rep").live("click",function(){

    if($(this).hasClass('question')){
    $(this).removeClass('question').addClass("v").next('li').css('list-style-image','url("./assets/img/_v.png") ')    ;
    }
    else if($(this).hasClass('v')){
      $(this).removeClass('v').addClass("-").next('li').css('list-style-image','url("./assets/img/-.png") ')    ;
    }
    else if($(this).hasClass('-')) {

      $(this).removeClass('-').addClass("question").next('li').css('list-style-image','url("./assets/img/_question.png") ')    ;
    }

      changed = true;
       saved = false;



 });

    $("#permissions ul li.arrow").live("click",function(){

       $(this).siblings('li').children().slideToggle("fast");


    });
$("h2.usertrigger span").live("click",function(){
		var name =  $(this).text();
		var dataUser =  $(this).parent().attr('data-user');

		userId =dataUser;

		$('input#name').val(name);

		$.ajax({
			  url: "users/getUsers/"+dataUser,
			  success: function(data,index)
			  {
				var groupusers =jQuery.parseJSON(data);
              globalUsers =      groupusers;
                     var groupsbyuser =  groupusers["AssignedToGroups"];

             $('#userlistings').empty();
            $("p.email").remove();
            $("#generaltmpl").tmpl(groupusers).insertAfter("#tabs-1 p.name");

            $("#groupstmpl").tmpl(groups).appendTo("#addselecteduser select");


			$("#usersgrouptmpl").tmpl(groupsbyuser).appendTo("#userlistings");

           	$("#accounttmpltest").tmpl(_accountdata).appendTo('#accountscombo select');
               permissionsMark();
              var permittedUser = groupsbyuser;


				$.each(permittedUser,function(k,v){



					$('#addselecteduser select option[value='+v.GroupID+']').remove();


				});


                   if(globalUsers["IsActive"]){

                $("p.enable #checkbox").attr("checked",true);


            }

                  $("#email").attr("value",globalUsers["Email"]);
				  }

		});


		$("#usertabs").dialog({
            draggable: true,
            autoOpen:false,
		title:name,
         modal:true,
		resizable: true,
		width:800,
		height:600,
        resize:function(){
            $("#permissions").css("height",$(this).dialog().height()-50-38);
            $("#userlist").css("height",$(this).dialog().height()-50-38);
        },
		buttons: {  "Cancel": function() {
					$( this ).dialog( "close" );
                },
				"Save and exit": function() {
                     sendUsersWithoutPermissions();
                    sendWithPermission();
                  $( this ).dialog( "close" );
				},
				"Save": function() {

                     sendUsersWithoutPermissions();
                           sendWithPermission();

                    $("div.overlay").hide();


				}


			}



		}).tabs();



         $(".ui-dialog-title").attr("title","ID:"+"" +userId);

          //$('.ui-dialog-buttonpane button:last').hide();
         $("#usertabs").dialog("open");
	});

	//$("#tabs").tabs({ disabled: [2] });
	$("a#add").button();

      getTree();




 }) ;
 function getTree(){
 $.ajax({
  url: "Users/gettree",
  success: function(data){

  	var permission = jQuery.parseJSON(data);




  	var html =  recursiveFunction(permission);

  $('#permissions').append(html);


 }
 });


       }
  function recursiveFunction(permission) {
              var result = "";

           var str = "";



                  $.each(permission, function(key,val) {

                      if(val.ChildPermissions != "")
                          {

                          var func= recursiveFunction(val.ChildPermissions);

                          str =str+ '<ul><li class="arrow"></li><li class="rep question"></li><li class="data" id="root" data-name="'+val.PermissionName+'" data-path='+val.Path+'>'+val.PermissionName+func+'</li></ul>';

                          }

                      else
                      {
                              str = str+'<ul><li class="arrowchild"><li class="rep question"></li><li id="son"  class="data" data-name="'+val.PermissionName+'" data-path='+val.Path+'>'+val.PermissionName+'</li></ul>';
                      }


                });


           return str;



          }

function sendWithPermission(){
  var assigned = [];
      var value = null ;
      var name;
            $("#permissions li.data").each(function(){
          if($(this).attr("data-name")) {

              if($(this).prev("li").hasClass("v")){

                  value = true;
              }
              else if($(this).prev("li").hasClass("-"))
              {

                  value = false;
              }
              else if($(this).prev("li").hasClass("question"))
              {

                  value = null;
              }

              if(value != undefined || value != null){


           var   json = {
                     "PermissionName":$(this).attr("data-name"),
                      "PermissionType": $(this).attr("data-path"),
                      "value":value


                  } ;

                   assigned.push(json) ;

              }



          }



     });


      globalUsers["AssignedPermissions"][globalID]=  assigned;

     var jsonuser = JSON.stringify(globalUsers);

    $.ajax({
       dataType:"json",
     type: "POST",
      data: jsonuser,
      url: 'Users/sendUser/'+userId,

      success: function(data){

          $("h2.usertrigger[data-user='"+userId+"']").find("span").text($("#name").val());
          saved = true  ;

      },
        error:function(data){


        }
});

}
function sendUsersWithoutPermissions(){


 var groupsforuser =  [];
  if(globalUsers["Name"] != $("#name").val()){

         globalUsers["Name"] =   $.trim($("#name").val());

      }

   if(globalUsers["Email"] != $("#Email").val()){
    globalUsers["Email"]=  $.trim($("#email").val());
    }

     globalUsers["IsActive"]= $("p.enable #checkbox").attr("checked");


      $("#userlistings li").each(function(){
         if($(this).attr("id")){
          var groupID = $(this).attr('id');
             var group = {
                            GroupID:$(this).attr("id") ,
                            Name:$(this).text()
             };
        groupsforuser.push(group)  ;

         }



     });

    globalUsers["AssignedToGroups"] =groupsforuser ;







 }
 $('#accountscombo').click(function(){

    if(changed  && !saved)
     {

         $("#modal").html('<p class="changemodal">You must save changes before you can edit permissions.</p>').dialog({
             title:"Save",
             modal:true,
             buttons:{
                       "Cancel":function(){
                         $(this).dialog("close");
                         saved = true;
                         changed = false;
                       },
                       "Ok":function(){



                          $(this).dialog("close");

                   }
             }

         });
         }
 });

 $('#accountscombo select').change(function(){


    permissionsMark();


});
 function permissionsMark(){


    var $id =$('#accountscombo select option:selected').attr("id");
     globalID = $id;
    var position="";
    var parent  = $(this).parent().parent().prev();
    var grand = parent.parent().parent().parent();
     var dataname ;
    var gid = "";
   changed = false;
   saved = false;

$.ajax({
  url: "users/getUsers/"+userId,
  success: function(data){
       $("#permissions li.data").css('list-style-image','url("./assets/img/_question.png") ')  ;
      var group = jQuery.parseJSON(data);

      globalGroups =   group;
       var users = {  };
        var groupUsers =  group["Members"];

      var assignedpermission  =   group["AssignedPermissions"][$id];



        if(assignedpermission || assignedpermission != undefined)
        {




          $.each(assignedpermission,function(key,persmission){


                  $("#permissions li.data").each(function(){
                     dataname =      $(this).attr('data-name');



                    if($(this).attr('data-name').toLowerCase() == persmission.PermissionName.toLowerCase() ) {

                            if(!persmission.Value )  {

                                $(this).css('list-style-image','url("./assets/img/-.png") ').prev().removeClass("question").addClass('-');
                            }
                               else
                            {

                              //  $(this).css('color','red');
                                $(this).css('list-style-image','url("./assets/img/_v.png")').prev().removeClass("question").addClass('v');

                              }



                    }




             });

          });

        }

  },
    complete:function(data){

      saved = false;

    },
    error:function(){


    }

});




}
</script>

<style type="text/css">




.opened{
  color: #616161;
list-style-image:url('./assets/img/minus_04.png');
}
.close{

list-style-image:url('./assets/img/plus_04.png')
}
li.child{
  color: black;

}
li.grandchild{
  color: black;
}
.ui-tabs .ui-tabs-nav {
    font-size: 14px;
    margin: 0;
    padding: 0 0 0;
     -moz-border-radius: 0; /* FF1+ */
  -webkit-border-radius: 0; /* Saf3-4, iOS 1+, Android 1.5+ */
          border-radius: 0;
}




#userlist,#permissions{
overflow-y:auto;
color:#666;
height:400px;
     position: relative;
     margin-top: 15px;
         margin-left: 10px;
}


#permissions ul{


    position:relative ;
    margin:0;

}
#permissions ul li{
      line-height: 20px;
    position:relative;
    list-style-image:url("./assets/img/_question.png")   ;
    vertical-align:top;
}

#permissions ul li#root:before{
    content:"";
    position:absolute;
  background:url('./assets/img/arrow-down_01.png') no-repeat 0 100%;
    left:-40px;
    width:8px;
    height:15px;


}

#tabs-3{

    position:relative;
}

.overlay{
     display:none;
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
   background-color: white;
   opacity:0.9;
    filter: alpha(opacity=90);

}
#msg{

    border: 1px solid black;
    left: 25%;
    margin: 0 auto;
    padding: 10px;
    position: absolute;
    text-align: center;
    top: 50%;

}
#permissions  li#son {

}
 #permissions ul li#son:before{
    content:"";
    position:absolute;
  background:url('./assets/img/arrow-right_01.png') no-repeat 0 100%;
    left:-40px;
    width:8px;
    height:9px;
     top:5px;


}
#addselecteduser{
	width: 500px;
	height:25px;
	float: left;
	color: white;
	position:relative;
	z-index: 1000;
}

#addselecteduser>select{
width:300px;
background:#F5F5F5;
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px;
position: absolute;
z-index: 1000;
top:0;
border:1px solid #F5F5F5;
margin-right:4px;
float: left;
font-size: 12px;
padding: 5px;
    color:#666;

}
#accountscombo>select:hover,#addselecteduser>select:hover{
     border-color:#90B63D;

}
#accountscombo select {
 background:#F5F5F5;
  font-size: 12px;
padding: 5px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px;

border:1px solid #F5F5F5;
}
#addselecteduser>select:selected{

font-size: 12px;
}
#addselecteduser>select>option{

font-size:12px;
width: 100%;

}
#addselecteduser a#add{
float: right;
width: 20%;
display: block;
}
#userlistings{
width:300px;
display: block;
  margin: 0;
    padding: 0;

}

#userlistings li{
  float: left;
    list-style: none outside none;
    margin: 10px 0;
    position: relative;
    text-indent: 24px;
    width: 100%;


}
#userlistings li:hover{

    background:#F5F5F5;
   -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius: 5px;

}
#userlistings li:hover:before{
    position:absolute;
    content:"X";
    margin-right:10px;
    font-weight:bold;
    color:red;
    left:-20px;
 text-shadow: 1px 1px 1px #383838;
filter: dropshadow(color=#383838, offx=1, offy=1);

}
.ui-button {
float: right !important;
}
#usertabs{
	display:none;
	width: 80%;
    overflow:hidden;



}
#userwrapper{
	width: 100%;
	overflow:hidden;
}
#usercontent{
    width:50%;
    overflow:hidden;
    border: 1px solid #C2C3C5 ;
    margin: 0 auto;


}
h2.usertrigger {
	background:#F5F5F5 url('assets/img/tb-closed.png') left no-repeat ;
    border-top:1px solid #C2C3C5;
    float:left;
    font-family:"verdana";
    font-size:14px;
    font-weight:normal;
    height:23px;
    line-height:23px;
    margin:0;
    outline:medium none;
    padding:0 0 0 50px;
    width:100%;
        position:relative;
		width:95%\9;
 color: #616161;
}
h2.usertrigger a {

	text-decoration: none;
	display: block;
	color: #616161;


}

h2.usertrigger:hover{

    background:#E3E3E3 url("assets/img/tb-closed-hover.png") left no-repeat   ;

}
h2.usertrigger a:hover {
    color:#7CA81D;

}

h2.usertrigger img{
position:absolute;

width:16px;
height:16px;
top:3px;



right:10%;
}

h2.groupactive {

    background:#E3EDCB url("assets/img/tb-open.png") left no-repeat;
    padding: 0 0 0 50px;
	height:23px;
    line-height:23px;
	width: 100%;
	font-size: 14px;
    font-family:"verdana";
	font-weight: normal;
	float: left;
    position:relative;
	width:95%\9;

}

/*--When toggle is triggered, it will shift the image to the bottom to show its "opened" state--*/


h2.usertrigger:hover{
    background:#E3EDCB url("assets/img/tb-open-hover.png") left no-repeat;

}
.group_toggle_container {
	margin: 0;
	padding: 0;
	font-size: 12px;
    overflow:auto;
	width: 100%;
	clear: both;
    display: block;
}




.toggle_container .block {
	padding: 0; /*--Padding of Container--*/
	width:960px;
    font-size:12px;
    margin-top:0;
    margin-bottom:0;

}
/*
#accountscombo{
display:none;
font-size: 12px;
font-family: verdana;
position:absolute;
z-index:100000;
background-color: #F5F5F5;
width: 100%;
height: 300px;
overflow: auto;
top:22px;


}
#accountscombo ul{

padding-left:20px;
}
#accountscombo li{
list-style: none;
margin-left: 1px;

}
*/
#accountwrap{
width: 500px;
font-size: 12px;
position: relative;


}

#arrows{
width: 19px;
position: absolute;
top:1px;
height:19px;
right: 2px;
}

.comboregular{

    background: url("assets/img/down-arrow_04.png") left no-repeat;

}

.openarrow{

    background:url("assets/img/down-arrow-pressed_04.png") left no-repeat;


}

#permissions ul li.rep{
   /* float:left; */
    position:absolute;
    width:20px   ;
    height:20px;
    left:10px;
    z-index:10000000;
     list-style:none;
 background-color:red\9;
}
#permissions ul li.arrow,#permissions ul li.arrowchild {
    list-style:none;

}
#permissions ul li.arrow{
   position:absolute;
    width:8px;
    height:9px;
    left:0;
    z-index:10000;
   top:5px;


}



#tabs-1 label{
    float:left;
    width:64px;
    line-height:25px;


}
#tabs-1 input[type="text"]  {
    width:200px;
    padding:5px 3px 5px 3px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
     background: none repeat scroll 0 0 #F5F5F5;
    border:1px solid  #F5F5F5;
    color:    #666666;




}
#tabs-1 input[type="text"]:focus{

   border-color:#90B63D;

}
#tabs-1 input[type="checkbox"]{
    float:left;
      margin-left: 1px;
    margin-top:7px;
}

.changemodal{
    margin-left:30px;

}


</style>
