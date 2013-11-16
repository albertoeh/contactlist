
function login()
{
    if($("#login_email").val() === "" || $("#login_password").val() === ""){
        alert("You must fill all the fieds");
    }
    else{ 
        makeAjaxCall('method=login&email='+$("#login_email").val()+'&password='+$("#login_password").val(),'login','loginCallback'); 
    }
}

function signin()
{
    if($("#signin_name").val() === "" || $("#signin_email").val() === "" || $("#signin_password").val() === ""){
        alert("You must fill all the fieds");
    }
    else{
        if(!isEmail($("#signin_email").val())) alert("The email is not correct");
        else{ 
            makeAjaxCall('method=signin&name='+$("#signin_name").val()+'&email='+$("#signin_email").val()+'&password='+$("#signin_password").val(),'login','loginCallback'); 
        }
    }
}

function deleteUser()
{
    if(confirm("All your data (even your access data) will be removed. Do you agree?")){ 
        location.href = baseurl + "login/delete";
    }
}

function updateFilter()
{
    makeAjaxCall('method=updateFilter','home','updateFilter'); 
}

function updateTable()
{
    makeAjaxCall('method=updateTable&category='+$("#filter").val(),'home','updateTable');
}

function addContact()
{
    makeAjaxCall('method=addContact&name='+$("#inputName").val()+'&telephone='+$("#inputTelephone").val(),'home','addContact');
}

function showContactPopup(id)
{
    $("#contactPopup").dialog("open");
    $("#idContact").val(id);
    makeAjaxCall('method=getContactData&id='+id,'home','getContactData');
}

function updateContact()
{
    makeAjaxCall('method=updateContact&'+$("#contactForm").serialize(),'home','updateContact');
}

function deleteContact(id)
{
    if(confirm("This contact will be deleted. If you only want to remove it from a category you must press the 'edit ' button")){
        makeAjaxCall('method=deleteContact&id='+id,'home','deleteContact');
    }      
}

function newCategory()
{
    makeAjaxCall('method=addCategory&name='+$("#categoryName").val(),'home','addCategory'); 
    $("#categoryPopup").dialog("close");
}

function deleteCategory()
{
    if(confirm("The '"+$("#filter option:selected").text()+"' category will be remove, but not its contacts. Do you agree?")){
        makeAjaxCall('method=deleteCategory&id='+$("#filter").val(),'home','deleteCategory');
    }
}

/*
 * @param {string} data: data supplied to the server in serialized format
 * @param {string} controller: 
 * @param {string} op: operation to do in the "returnAjaxData" function
 * @param {bool} sync: if true (by default) ajax connection is synchronous
 */
function makeAjaxCall(data, controller, op, sync){ 
    //alert(baseurl+"/"+controller+"/ajax , "+data);
    if (sync === undefined) sync = true;
    $.ajax({ type: "post",
    url: baseurl+controller+"/ajax",
    cache: false,
    async: sync,
    data: data,
    success: function(json){
        try{	
            //alert(json);
            var obj = jQuery.parseJSON(json);
            if (obj == "expired"){
                alert("The session  has expired");
                location.href = baseurl + "login";
                return;
            }
            returnAjaxData(op,obj)
        }catch(e) {
                alert('Exception while request...');
        } 
    },
    error: function(){
        alert('Error while request...');
    }
    });
}

function returnAjaxData(op, obj){
    switch (op) {
        case "loginCallback":
            if(obj.state === "ok") location.href = baseurl + "home";
            else alert("There is not any user with this email and password");
        break;
        case "signinCallback":
            if(obj.state === "ok") location.href = baseurl + "home";
            else alert("There is already an user registered with this email");
        break;
        case "updateFilter":
            $("#filter").empty();
            $("#filter").append("<option value='0' onclick='updateTable()'>All</option>");
            for(var i=0; i<obj.categories.length; i++){
                $("#filter").append("<option value='"+obj.categories[i].id+"' onclick='updateTable()'>"+obj.categories[i].name+"</option>");    
            }
            updateTable();
        break;
        case "updateTable":
            $("#contactTable").html('<tr id="header_row"><td>Name</td><td class="tel">Telephone</td><td></td></tr>');
            for(var i=0; i<obj.contacts.length; i++){
                $("#contactTable").append("<tr><td>"+obj.contacts[i].name+"</td><td class='tel'>"+obj.contacts[i].telephone+"</td>"+
                                          "<td class='op'><input type='button' value='Edit' onclick='showContactPopup("+obj.contacts[i].id+")'>"+
                                          "<input type='button' value='Delete' onclick='deleteContact("+obj.contacts[i].id+")'></td></tr>");
            }
            if($("#filter").val()==0) $("#deleteCategoryButton").css("display","none");
            else $("#deleteCategoryButton").css("display","inline");
        break;
        case "addContact":
            if(obj.state === "ok") {
                $("#inputName").val("");
                $("#inputTelephone").val("");
                $("#filter").val(0); //We choose the 'All' category before updating the table
                updateTable();
            }
            else alert("Error while adding the contact");        
        break;
        case "deleteContact":
            if(obj.state === "ok") updateTable();
            else alert("Error while deleting the contact");       
        break;
        case "addCategory":
            if(obj.state === "ok"){
                $("#categoryName").val("");
                updateFilter();
            }
            else if(obj.state === "repeated") alert("You already have a category with this name");
            else alert("Error while adding the category");
        break;
        case "deleteCategory":
            if(obj.state === "ok") updateFilter();
            else alert("Error while deleting the category");       
        break;
        case "getContactData":            
            if(obj.state === "ok"){ 
                //First we fill the text inputs
                $("#contactName").val(obj.contact.name);
                $("#contactTelephone").val(obj.contact.telephone);
                //Later we add all the user categories 
                $("#contactCategories").empty();
                for(var i=0; i<obj.userCategories.length; i++){
                    $("#contactCategories").append("<input type='checkbox' name='category"+obj.userCategories[i].id+"'"+
                                                   "id='category"+obj.userCategories[i].id+"' /> "+obj.userCategories[i].name+"<br />");    
                }
                //Finally we set only the categories of this contact
                for(var i=0; i<obj.contactCategories.length; i++){
                    $("#category"+obj.contactCategories[i].category).attr('checked', true);    
                }
            }
            else alert("Error while getting data");       
        break;
        case "updateContact":
            if(obj.state === "ok") updateTable();
            else alert("Error while updating the contact");
            $("#contactPopup").dialog("close");
        break;
           
    }
}


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}