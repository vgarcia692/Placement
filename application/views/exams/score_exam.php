<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 well">
        <?php echo validation_errors(); ?>
            <?php echo form_open('scorings/processScore') ?>
            <h3><label class="label label-info"><?php if (isset($_SESSION['examScoreMessage'])) {
                echo $_SESSION['examScoreMessage'];
            } ?></label></h3>
                <legend>Score Exam <?php echo $exam['id']; ?></legend>
                <input type="number" name="id" hidden value="<?php echo $exam['id']; ?>"></input>
                <input type="number" name="page" hidden value="<?php echo $page; ?>"></input>
            
                <div class="form-group">
                    <label for="score">Writing Sample Score</label>
                    <input type="number" class="form-control" id="score" name="score" max='4' min="0" required>
                </div>
            
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>