<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 01/03/2018
 * Time: 15.10
 */?>

<div class="x_panel">
    <div class="x_title">
        <h2>Report Karyawan Project</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="col-md-12">


            <br>

            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Daily Activity</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">By Complain Custome</a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="tab_content1" aria-labelledby="home-tab">

                        <!-- start recent activity -->
                        <ul class="messages">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Nama Karyawan </th>
                                        <th class="column-title">Project On </th>
                                        <th class="column-title">Jobs Today </th>
                                        <th class="column-title">Rating </th>
                                        <th class="column-title">Update On </th>
                                        <th class="column-title">By SPv </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="even pointer">


                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </ul>
                        <!-- end recent activity -->

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                        <!-- start user projects -->

                        <ul class="messages">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Nama Karyawan </th>
                                        <th class="column-title">Project On </th>
                                        <th class="column-title">Rating </th>
                                        <th class="column-title">Cupon Complain </th>
                                        <th class="column-title">Keterangan </th>
                                        <th class="column-title">Create Date </th>
                                        <th class="column-title">SPv </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </ul>


                        <!-- end user projects -->

                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
