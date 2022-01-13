<!-- client more information popup -->
<div class="client-information-popup">
    <!-- Modal -->
    <div class="modal fade" id="grantAccess" tabindex="-1" role="dialog" aria-labelledby="grantAccess"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popup-box text-center pt-lg-5 mt-lg-3">
                        <h3>Grant users access to the campaign for <br>
                            <span class="campaign-name">{{ $campaign->cajobtitle }}</span>
                        </h3>
                        
                    </div>
                    <div class="popup-box">                        
                        <div class="row append-grant-access-data">
                        
                        </div>

                        <div class="setup-accordion">
                            <div class="accordion append-grant-access" id="accordionExample">

                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:;" class="circle50 add-more-access"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-0" id="grant-access-block" style="display: none">
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
            <form class="row grant-access-form" method="post" action="javascript:;" data-action="{{ route('grant_access.store') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <input type="hidden" name="uaid" class="uaid" id="uaid">
                    <input type="hidden" name="id" class="grant-access-user-id" id="grant-access-user-id">
                    <input type="hidden" name="client_id" class="client_id" id="client_id" value="{{$client_id}}">
                    <input type="hidden" name="camping_id" class="camping_id" id="camping_id" value="{{$id}}">

                    <div class="form-group col-lg-5">
                        <select class="form-control user-select" name="user">
                            <option value="user">Select user</option>
                        </select>
                    </div>
                    <div class="form-group upload-delete col-lg-7">
                        <select class="form-control user-access-select"
                                name="user_access">
                            <option value="">User Access Rights</option>
                            <option value="1">administrator</option>
                            <option value="2">User</option>
                        </select>
                        <div class="delete">
                            <button type="submit" class="grant-access-save-btn" style="background: none">
                                <a href="javascript:;" class="circle50">
                                    <img src="{{ asset('assets/images/file.png') }}" alt="file">
                                </a>
                            </button>
                            <a href="javascript:;" class="circle50 grant-access-delete-btn">
                                <img src="{{ asset('assets/images/delete.png') }}" alt="delete">
                            </a>
                        </div>
                    </div>
                <!-- </div> -->
            </form>
        </div>
    </div>
</div>