<?php
include './htmlHelpers.php';
include './admin/functions.php';
renderHtmlStart("commentaar", "");
?>
<br>
<div class="comment">
    <table  class="comment">
        <tr>
            <td><strong>Gastenboek </strong></td>
        </tr>
    </table>
    <table class="comment1">
        <tr>
        <form id="form1" name="form1" method="post" action="addguestbook.php">
            <td>
                <table class="comment2">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><input name="name" type="text" id="name" size="40" /></td>
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
                        <td><input type="submit" name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /></td>
                    </tr>
                </table>
            </td>
        </form>
        </tr>
    </table>
    <table class="comment">
        <tr>
            <td><strong><a href="gastenboek.php">Bekijk Gastenboek</a> </strong></td>
        </tr>
    </table>

</div>

<?php
renderHtmlEnd();
?>