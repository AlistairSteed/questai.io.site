$(document).ready(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('fixbody');
    })

    $('.assessment-additional-popup .assessments .cv-block .add-cart a').click(function(){
      $(this).parent('.assessment-additional-popup .assessments .cv-block .add-cart').toggleClass('added')
    })
});

$('#inputDate').datepicker({
});
$('#inputDate2').datepicker({
});
$('#inputDate3').datepicker({
});
$('#inputDate4').datepicker({
});

 var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },

          breakpoints: {
            320: {
                slidesPerView: 1,

             },
             601: {
                slidesPerView: 2,

             },
             991: {
                slidesPerView: 3,

             },
             1060: {
                slidesPerView: 4,

             }
          }
      });


      // textarea js
      // box 1
      var quill = new Quill('.jobPost-editor1', {
         modules: {
           toolbar: [
             ['bold', 'italic', 'underline'],
             [{ 'list': 'ordered'}, { 'list': 'bullet' }],
             ['link']
           ]
         },
          placeholder: quillPlaceholderTexts.jobDescription,
         theme: 'snow' // or 'bubble'
       });
      var quill = new Quill('.jobPost-editor6', {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link']
          ]
        },
        placeholder: quillPlaceholderTexts.clientDescription,
        theme: 'snow' // or 'bubble'
      });
      // box 1
      var quill = new Quill('.jobPost-editor3', {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link']
          ]
        },
        placeholder: quillPlaceholderTexts.essesntialSkillsAndQualifications,
        theme: 'snow' // or 'bubble'
      });
      // box 1
      var quill = new Quill('.jobPost-editor4', {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link']
          ]
        },
        placeholder: quillPlaceholderTexts.preferredSkillsAndQualifications,
        theme: 'snow' // or 'bubble'
      });
      // box 1
      var quill = new Quill('.jobPost-editor5', {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link']
          ]
        },
        placeholder: quillPlaceholderTexts.additionalInformation,
        theme: 'snow' // or 'bubble'
      });




