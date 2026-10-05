<div class="modal fade" id="fehlerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    ⚠️ Fehlermeldung
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form id="fehlerForm" action="index.php" method="POST">

                    <div class="mb-3">
                        <label for="fehlerText" class="form-label">
                            Was ist passiert?
                        </label>

                        <textarea
                            id="fehlerText"
                            class="form-control"
                            rows="5"
                            placeholder="Beschreibe den Fehler..."
                            required
                            ></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        Fehlermeldung abschicken
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>