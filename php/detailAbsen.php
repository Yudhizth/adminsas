<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/02/2018
 * Time: 02.54
 */

$ktp = $_GET['ktp'];

$
?>

<div class="col-md-6 col-sm-6 col-xs-12 well">
    <h4 class="title">Range Absen</h4>
    <div class="x_content" data-parsley-validate="">
        <form class="form-horizontal form-label-left input_mask">

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name" required>
                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name" required>
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="txt_start" class="form-control has-feedback-left" id="single_cal1" aria-describedby="inputSuccess2Status4">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                <input type="text" name="txt_start" class="form-control has-feedback-left" id="single_cal2" aria-describedby="inputSuccess2Status4">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>


            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="button" class="btn btn-primary">Cancel</button>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>
<script src="./vendors/js/jquery-1.10.2.js"></script>
<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
