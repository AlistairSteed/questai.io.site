<!-- comment popup -->
<div class="comment-popup">
  <!-- Modal -->
  <div class="modal fade" id="candidate_comment" tabindex="-1" role="dialog" aria-labelledby="candidate_comment" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content popup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="popup-box text-center pt-lg-5 mt-lg-3">
            <h3>Candidate Comments</h3>              
            <input type="hidden" name="cocan-Id" class="cocan-Id" id="cocan-Id" value="">
          </div>
          <div class="popup-box">
            <ul class="comment-main append-candidate-comments-data">

            </ul>

            <!-- <ul class="comment-main"> -->
              <li id="comments-list" style="display: none">
                <p class="comments"></p>
                <div class="user-date">
                  <span class="comment-user">
                    <img src="{{ asset('assets/images/user-comment.png') }}" alt="user">
                    <span class="comment-username"></span>
                  </span>
                  <span class="comment-date">
                    <img src="{{ asset('assets/images/calendar.png') }}" alt="calander">                      
                    <span class="comment-datetime"></span>
                  </span>
                  <span class="comment-edit-span" style="display: none"><a href="#" class="comment-edit" id="comment-edit" data-toggle="modal" data-target="#edit-candidate-comment-block"><i class="fas fa-edit"></i></a></span>
                </div>
                <!-- <div><a href="">Edit</a></div> -->
              </li>
            <!-- </ul> -->
            <div class="content">
              <div class="setup-accordion">
                  <div class="accordion append-candidate-comment" id="accordionExample">

                  </div>
            </div>
          </div>
            <div class="add-more">
              <a href="#pills-candidates" class="circle50 add-more-candidate-comment"><i class="fas fa-plus"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- ----------------------------- Add Comment Start------------------------------------------- -->
<div class="card" id="candidate-comment-block" style="display: none">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span class="title-text"> Comment</span>
                    <img src="{{ asset('assets/images/arrow-down.png') }}" alt="arrow">
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse collapse-block" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <form class="row candidate-comment-form" method="post" action="javascript:;" data-action="{{ route('add-candidate-comment') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="candidate_id" class="candidate-id" id="candidate-id" value="">
                    <input type="hidden" name="client_id" class="client_id" id="client_id" value="{{$client_id}}">
                    <input type="hidden" name="camping_id" class="camping_id" id="camping_id" value="{{$id}}">
                    <div class="form-group col-lg-12">
                        <textarea type="text" class="form-control candidatecomment" name="candidate_comment" id="candidatecomment"
                                  placeholder="Add Comment"></textarea>
                    </div>
                    <div class="form-group upload-delete col-lg-12 justify-content-center mt-2">
                        <div class="delete">
                            <button type="submit" class="candidate-comment-save-btn" style="background: none">
                                <a href="javascript:;" class="circle50">
                                    <img src="{{ asset('assets/images/file.png') }}" alt="file">
                                </a>
                            </button>
                            <a href="javascript:;" class="circle50 candidate-comment-delete-btn">
                                <img src="{{ asset('assets/images/delete.png') }}" alt="delete">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- ----------------------------- Add Comment End------------------------------------------- -->


<!-- ----------------------------- Edit Comment Start------------------------------------------- -->
<div class="comment-popup">
  <!-- Modal -->
  <div class="modal fade" id="edit-candidate-comment-block" tabindex="-1" role="dialog" aria-labelledby="edit-candidate-comment-block" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content popup">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="popup-box text-center pt-lg-5 mt-lg-3">
            <h3>Edit Candidate Comments</h3>            
          </div>
          <div class="popup-box">
            <div class="card-body">
              <form class="row edit-candidate-comment-form" method="post" action="javascript:;" data-action="{{ route('edit-candidate-comment') }}" enctype="multipart/form-data" autocomplete="off">
                  @csrf                 
                  <input type="hidden" name="comments_id" class="comments_id" id="comments_id" value="">
                  <input type="hidden" name="candidate_id" class="candi-id" id="candi-id" value="">
                  <input type="hidden" name="client_id" class="client_id" id="client_id" value="{{$client_id}}">
                  <input type="hidden" name="camping_id" class="camping_id" id="camping_id" value="{{$id}}">
                  <input type="hidden" name="couser" class="couser" id="couser" value="">
                  <div class="form-group col-lg-12">
                    <textarea type="text" class="form-control edit_candidate_comment" name="candidate_comment" id="editcandidatecomment"
                                placeholder="Edit Comment"></textarea>
                  </div>
                  <div class="form-group upload-delete col-lg-12 justify-content-center">
                    <div class="delete">
                      <button type="submit" class="edit_candidate-comment-save-btn" style="background: none">
                        <a href="javascript:;" class="circle50">
                            <img src="{{ asset('assets/images/file.png') }}" alt="file">
                        </a>
                      </button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ----------------------------- Edit Comment End------------------------------------------- -->

