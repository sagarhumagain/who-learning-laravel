import VueSweetalert2 from 'vue-sweetalert2';

export default class Functions{
    imageUpload(e,data,field) {
        let file = e.target.files[0];
        let reader = new FileReader();
        if (file['size'] < 2500000) {
            reader.readAsDataURL(file);
            reader.onloadend = (file) => {
                data[field] = file.target.result;
            }
        } else {
          this.emitter.emit({
                type: "warning",
                title: 'Opps..!',
                text: 'File size is too large. Please upload a file less than 2.5MB',
              })
        }
    }
    enrollCourse(id) {
        this.$swal({
            title: 'Are you sure to enroll to this course?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, enroll!'
        }).then(async (result) => {
            if (result.value) {
                try {
                  let response = await this.$api.courses.enrollToCourse({course_id: id});
                  this.$swal(
                        'Enrolled!',
                        'You have successfully enrolled to the course.',
                        'success'
                    );
                    this.emitter.emit('AfterEnrolledCreate')
                } catch(e) {
                  this.$swal(
                      'Warning!',
                      'Could not enroll to course.',
                      'warning'
                  )
                }
            }

        })
    }



}





