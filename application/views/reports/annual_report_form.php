<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 well">
            <legend>Annual Report</legend>
            <p><?php echo validation_errors(); ?></p>
            <h4 class="errorlabel"><?php if (isset($_SESSION['flashError'])) {echo $_SESSION['flashError'];} ?></h4>
            <?php echo form_open('reports/processAnnualReport'); ?>
                <legend>Select a School Year</legend>
                <div class="form-group">

                    <label for="sy">Schoo Year:</label>
                    <select id="sy" name="sy" class="form-control">
                        <?php foreach ($testYearOptions as $testYear) { ?>
                            <option><?php echo $testYear; ?></option>
                        <?php } ?>
                    </select>
                </div>                

                <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
            </form>

        </div>
    </div>
</div>
