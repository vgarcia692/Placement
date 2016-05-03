<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 well">
        <legend>Upload Requirements</legend>
        <p>In order to upload logs into the system you must make sure the file meets all requirements:</p>
        <ol>
            <li>File is a CSV File Windows(CSV)/MAC(WINDOWS COMMA SEPERATED)</li>
            <li>The columns are maintained in the same order when pulled from the remark system.</li>
            <li>If the fields are included you must checkoff the "CSV Includes Fields?"</li>
            <li>If the file you are uploadind is from community and not high school please check off the community checkbox.</li>

        <?php echo validation_errors(); ?>
            <?php echo form_open_multipart('upload/processUpload') ?>
            <h3><label class="label label-info"><?php if (isset($_SESSION['uploadMessage'])) {
                echo $_SESSION['uploadMessage'];
            } ?></label></h3>
                <legend>Upload Logs</legend>
                
                <div class="form-group">
                    <label for="userfile">CSV File</label>
                    <input type="file" class="form-control" name="userfile"></input>
                </div>

                <div class="form-group">
                    <label for="testDate">Testing Date</label>
                    <input type="date" class="form-control" name="testDate"></input>
                </div> 

                <div class="form-group">
                    <label for="isCommunity">Community Upload</label>
                    <input type="checkbox" class="form-control" name="isCommunity" value="1"></input>
                </div> 

                <div class="form-group">
                    <label for="doNotIncludesFields">CSV Does Not Includes Fields?</label>
                    <input type="checkbox" class="form-control" name="doNotIncludesFields" value="1"></input>
                </div>  
            
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>