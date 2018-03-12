<div class="widget-sidebar widget-search">
    <div class="card-panel teal">

        <form action="{{ route('search') }}">
            <div class="row">
                <div class="col s9">
                    <div class="input-field white-text left">
                        <input type="text" id="keyword" name="q" class="white-text">
                        <label class="white-text" for="keyword">Search</label>
                    </div>
                </div>
                <div class="col s3">
                    <button class="btn-floating btn-large waves-effect waves-teal white right" type="submit">
                        <i class="material-icons teal-text">search</i>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
