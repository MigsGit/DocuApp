<template>
    <div>
      <!-- Button to open modal -->
      <!-- <button type="button" class="btn btn-primary" @click="toggleModal">Open Modal</button> -->
     <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" id="btnTest"><i class="fas fa-plus"></i> Add</button>


      <!-- Modal   id="modalCreateDocument"-->
      <!-- <div id="testing" class="modal" tabindex="-1" role="dialog"> -->
    <div class="modal fade" id="testing" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <!-- <div
      v-if="isModalOpen"
      class="modal"
      style="display: block;"
      tabindex="-1"
      role="dialog"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    > -->
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Smooth Animated Modal</h5>
              <button type="button" class="close" @click="toggleModal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <!-- <div class="animate__animated animate__slideInRight"> -->
                    <!-- Row 1 -->
                    <transition name="fade" mode="out-in">
                        <div v-show="showFirstRow" class="row mb-2 animate__animated animate__slideInRight">
                            <div class="col">
                                <p>This is the first row of the modal.</p>
                            </div>
                        </div>
                    </transition>

                    <!-- Row 2 -->
                    <transition name="fade" mode="out-in">
                        <div v-show="showSecondRow" class="row animate__animated animate__slideInRight">
                            <div class="col">
                                <p>This is the second row of the modal.</p>
                            </div>
                        </div>
                    </transition>
                <!-- </div> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="toggleRow('first')">Toggle First Row</button>
              <button type="button" class="btn btn-secondary" @click="toggleRow('second')">Toggle Second Row</button>
              <button type="button" class="btn btn-primary" @click="toggleModal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Backdrop for modal -->
      <div v-if="isModalOpen" class="modal-backdrop fade show"></div>
    </div>
  </template>

  <script setup>
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
    const test = ref(null);
    onMounted( () => {
        //modalOpenPdfImage
        test.value = new Modal(document.querySelector("#testing"),{});
        let btnEdocs = document.querySelector("#btnTest")
            btnEdocs.addEventListener('click', function(event){
                // console.log('dasdsa');
                test.value.show();
            })
    });
    // Reactive state
    const showFirstRow = ref(true); // First row visibility
    const showSecondRow = ref(false); // Second row visibility

    // Methods
    const toggleModal = () => {
      isModalOpen.value = !isModalOpen.value; // Toggle modal visibility
    };

    const toggleRow = (row) => {
      if (row === 'first') {
        showFirstRow.value = true; // Toggle first row visibility
        showSecondRow.value = false; // Toggle first row visibility
      } else if (row === 'second') {
        showSecondRow.value = true; // Toggle second row visibility
        showFirstRow.value = false; // Toggle second row visibility

      }
    };

    // return {
    //   isModalOpen,
    //   showFirstRow,
    //   showSecondRow,
    //   toggleModal,
    //   toggleRow
    // };
  </script>

<style scoped>
/* Fast fade-in/fade-out transition */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.01s ease-in-out; /* Fast transition */
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.content {
  padding: 10px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 5px;
}

</style>

