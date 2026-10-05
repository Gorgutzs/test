<div class="modal fade" id="QuelleHinzufügenModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                   Quelle Hinzufügen
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form id="QuelleHinzufügenForm" action="/ProjektVeranstaltungen/admin/quelle-hinzufuegen" method="POST">



                    <div class="mb-3 row align-items-center">
                        <label for="URL" class="col-sm-2 col-form-label"> URL eingeben:</label>

                        <div class="col-sm-10">
                        <input type="text" name="URL" id="URL" class="form-control">
                        </div>

                    </div>
                    
                    <div class="mb-3 row align-items-center">
                        
                        <label for="Name" class="col-form-label col-sm-2"> Name eingeben:</label>

                        <div class="col-sm-10">
                        <input type="text" name="Name" id="Name" class="form-control">
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="Scraper-Regel" class="form-label">
                            Scraper-Regel auswählen:
                        </label>

                        <select name="Scraper-Regel" class="form-select">
                            <option value="" selected disabled> Bitte eine Scraper-Regel auswählen</option>
                            <option value="Test"> Quelle 1</option>
                            <option> Quelle 2</option>
                            <option> Quelle 3</option>
                        </select>
                    </div>


                    <input type="hidden" name="X-CSRF-Token" value="<?= htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8") ?>" >


                    <div class="mb-3">
                        <label for="Aktivieren" calss="form-check-label">
                            Aktivieren: 
                        </label>

                        <input type="checkbox" id="Aktivieren" name="Aktivieren" class="form-check-input">
                    </div>


                    <button type="submit" class="btn btn-success">
                        Quelle Hinzufügen
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

    