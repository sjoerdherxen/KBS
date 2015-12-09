<?php
include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("commentaar", "");
?>


<?php
$id = 1; // komt uit get of post

$schilderij;
?>

<div class="img">
   
        <img src="$schilderij" alt="Logo" >
   
    <div class="title">Title</div>
</div>



<form id="form1" name="form1" method="post" action="schilderij.php">
    <input type="hidden"  name="id" value="<?php echo $id;?>" />
    <table class="comment1">
        <tr>
            <td>
                <table class="comment2">
                    <tr>
                        <td>Naam</td>
                        <td>:</td>
                        <td><input name="naam" type="text" id="name" size="40" /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input name="email" type="text" id="email" size="40" /></td>
                    </tr>
                    <tr>
                        <td >Comment</td>
                        <td >:</td>
                        <td><textarea name="comment" cols="40" rows="3" id="comment"></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit"  name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /></td>
                    </tr>
                    
                </table>
            </td>

        </tr>
    </table>
</form>

<?php
renderHtmlEnd();
?>