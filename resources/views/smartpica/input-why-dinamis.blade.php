<div class="row rw-1 " style="margin:3em; font-size:11px;">
    <div class="col cl-1 master" style="margin: 0px !important">
        <div class="row row-cols-6 r1">
            <div class="col-2">
                <fieldset style="margin: 30px">
                    <legend style="width: auto">Why 1</legend>
                    <div class="row">
                        <div class="col-5">
                            <div class="input-group input-group-static my-4">
                                <label class="ms-0" for="input-m-w1-1">Why 1 - 1</label>
                                <textarea type="textarea" id="input-m-w1-1" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input-group input-group-static my-4">
                                <label for="input-k-w1-1" class="ms-0 kategory-why">Kategori </label>
                                <select class="form-control" name="input-k-w1-1" id="input-k-w1-1" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($dataKategory as $d)
                                        <option value="{{ $d['id'] }}">{{ $d['text'] }}</option>
                                    @endForeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <button type="button" onclick="AddWhy2(1,1)" class="btn btn-primary">Why2</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="row rw-1 " style="margin:3em; font-size:11px;">
    <div class="col-5 d-flex justify-content-start align-items-left">
        <button type="button" class="btn btn-primary" onclick="AddWhy1()">Why1</button>
    </div>
</div>
