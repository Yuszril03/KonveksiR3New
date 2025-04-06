<!-- Modal -->
<div class="modal fade" id="alertAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content p-4" style="border-radius: 30px;">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <div class="modal-body text-center ">
                <img src="<?= base_url() ?>/Asset/Icon/AuthFail.svg" width="200" alt="">
                <h5 class="mt-4">Opss..</h5>
                <p>Akun anda sedang dipakai device lain</p>
                <button type="button" id="btnLogoutAlert" class="btn btn-primary">Oke</button>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>