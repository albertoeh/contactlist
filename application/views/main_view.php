<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contact list</title>
    <script src="<?php echo base_url("static/js/main.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("static/js/jquery-1.9.1.js")?>" type="text/javascript"></script>  
    <script src="<?php echo base_url("static/js/jquery-ui-1.10.3.custom.min.js")?>" type="text/javascript"></script>
    <script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
    <link rel="stylesheet" href="<?php echo base_url("static/css/smoothness/jquery-ui-1.10.3.custom.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("static/css/main.css"); ?>" />

</head>
<body>
    <div class="header">Welcome <?php echo $this->session->userdata("userName") ?> |
    <a onclick="deleteUser()"><b>Delete all</b></a> -   
    <a href="<?php echo base_url("login/logout"); ?>"><b>Exit</b></a></div>
    
    <div class="content">
        <form id="formNewContact">
            <fieldset>
            <legend>Add new contact</legend>
            <label for="inputName">Name:</label>
            <input type="text" id="inputName" required="" autofocus=""/>
            <label for="inputTelephone">Telephone:</label>
            <input type="text" id="inputTelephone" required=""/>
            <input type="button" value="Add contact" onclick="addContact()"/>
            </fieldset>
        </form>
        
        <div class="category_box">
            Filter: <select id="filter" onchange="updateTable()"></select>   
            <input id="deleteCategoryButton" type="button" style="display: none" value="Delete category" onclick="deleteCategory()">
            <input type="button" value="New category" onclick='$("#categoryPopup").dialog("open");'>
        </div>
        
        <div class="content_table">
            <table id="contactTable">
                
            </table>
        </div>
</div>
    
<div id="categoryPopup" title="New Category">
    <p>Write the name of the new category:</p>
     <label for="categoryName">Name:</label>
     <input type="text" id="categoryName" required="" autofocus=""/>
     <input type="button" value="Ok" onclick="newCategory()" />
     </form>
 </div>
    
<div id="contactPopup" title="Edit contact">
    <form id="contactForm">
    <input name="idContact" type="hidden" id="idContact" value="" />
    <label for="contactName">Name</label>
    <input name="contactName" type="text" id="contactName" required="" autofocus=""/><br />
    <label for="contactTelephone">Telephone</label>
    <input name="contactTelephone" type="text" id="contactTelephone" required="" autofocus=""/><br />
    <label>Categories</label>
    <div id="contactCategories"></div>
    <br /><br /><input type="button" value="Save data" onclick="updateContact()"/>
    </form>
 </div>    


    
<script type="text/javascript">
    updateFilter();
    $( "#categoryPopup" ).dialog({autoOpen: false,width: 'auto',modal: true});
    $( "#contactPopup" ).dialog({autoOpen: false,width: 'auto',modal: true});
</script>
</body>
</html>

