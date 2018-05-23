<div class="row">
                                <div class="col-md-4 col-xs-12 col-md-offset-4">
                                    <div class="form-group">
                                        <select id="timeType" class="form-control" required>
                                            <option value="">Pilih Waktu Kerja</option>
                                            <option value="fix">Waktu Fixed</option>
                                            <option value="flex">Waktu Flexsible</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="typeTime" id="typeTime">
                            <div class="form-group">
                                <div id="fixedTime">
                                    <div class="well">
                                        <div class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Minggu</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_minggu_start" id="mingguMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_minggu_end"  id="mingguKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Senin</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_senin_start" id="seninMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_senin_end"  id="seninKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Selasa</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_selasa_start" id="selasaMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_selasa_end"  id="selasaKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Rabu</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_rabu_start" id="rabuMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_rabu_end"  id="rabuKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Kamis</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_kamis_start" id="kamisMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_kamis_end"  id="kamisKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Jumat</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_jumat_start" id="jumatMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_jumat_end"  id="jumatKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Sabtu</label>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_sabtu_start" id="sabtuMasuk" placeholder="dari">
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <input type="text" class="form-control timepicker" name="txt_sabtu_end"  id="sabtuKeluar" placeholder="sampai">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="flexibleTime">
                                    <table class="table table-hover table-resposive">
                                        <thead>
                                        <tr><th>MINGGU</th>
                                            <th>SENIN</th>
                                            <th>SELASA</th>
                                            <th>RABU</th>
                                            <th>KAMIS</th>
                                            <th>JUMAT</th>
                                            <th>SABTU</th>
                                        </tr></thead>
                                        <tbody><tr>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_minggu" placeholder="HH" id="minggu">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_senin" placeholder="HH" id="senin">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_selasa" placeholder="HH" id="selasa">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_rabu" placeholder="HH" id="rabu">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_kamis" placeholder="HH" id="kamis">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_jumat" placeholder="HH" id="jumat">
                                            </td>
                                            <td width="14.2%">
                                                <input type="number" class="form-control" name="txt_sabtu" placeholder="HH" id="sabtu">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
