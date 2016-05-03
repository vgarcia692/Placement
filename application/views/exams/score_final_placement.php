<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 well">
        <?php echo validation_errors(); ?>
            <?php echo form_open('faculties/processFinalPlacement') ?>
            <h3><label class="label label-info"><?php if (isset($_SESSION['examScoreMessage'])) {
                echo $_SESSION['examScoreMessage'];
            } ?></label></h3>
                <legend>Score Exam <?php echo $exam['id'].' - '.$exam['f_name'].' '.$exam['l_name']; ?></legend>
                <input type="number" name="id" hidden value="<?php echo $exam['id']; ?>"></input>
                <input type="number" name="page" hidden value="<?php echo $page; ?>"></input>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Language Use Skill</th>
                            <th>Sentence Skill</th>
                            <th>Reading Skill</th>
                            <th>Writing Sample Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $exam['lu_total_score']; ?></td>
                            <td><?php echo $exam['ss_total_score']; ?></td>
                            <td><?php echo $exam['rs_total_score']; ?></td>
                            <td><?php echo $exam['writing_sample_score']; ?></td>
                        </tr>
                    </tbody>
                </table>
            
                <div class="form-group">
                    <label for="finalPlacement">Writing Sample Score</label>
                    <select name="finalPlacement" class="form-control">
                        <option value="1">(1) Level 1</option>
                        <option value="2">(2) Level 2</option>
                        <option value="3">(3) Level 3</option>
                        <option value="4">(4) Credit Level</option>
                    </select>
                </div>
            
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>