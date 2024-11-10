<template>
    <div>
      <h3>Dynamic Table with Input Fields</h3>

      <!-- Table -->
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Render each row dynamically -->
          <tr v-for="(row, index) in rows" :key="row.id">
            <td>{{ index + 1 }}</td>
            <td>
              <input
                type="text"
                v-model="row.firstName"
                placeholder="First Name"
                class="form-control"
              />
            </td>
            <td>
              <input
                type="text"
                v-model="row.lastName"
                placeholder="Last Name"
                class="form-control"
              />
            </td>
            <td>
              <input
                type="email"
                v-model="row.email"
                placeholder="Email"
                class="form-control"
              />
            </td>
            <td>
              <!-- Remove button for each row -->
              <button
                class="btn btn-danger"
                @click="removeRow(row.id)"
              >
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Button to add a new row -->
      <button class="btn btn-primary mt-3" @click="addRow">Add Row</button>
    </div>
  </template>

  <script>
  import { ref } from 'vue';
  import { v4 as uuidv4 } from 'uuid';

  export default {
    setup() {
      // Reactive array of rows, each row has unique id and default values
      const rows = ref([
        { id: uuidv4(), firstName: '', lastName: '', email: '' },
      ]);

      // Method to add a new row with unique id
      const addRow = () => {
        rows.value.push({ id: uuidv4(), firstName: '', lastName: '', email: '' });
      };

      // Method to remove a row by id
      const removeRow = (id) => {
        rows.value = rows.value.filter(row => row.id !== id);
      };

      return {
        rows,
        addRow,
        removeRow,
      };
    },
  };
  </script>

  <style scoped>
  .table {
    width: 100%;
    margin-top: 20px;
  }
  .form-control {
    width: 100%;
  }
  .btn {
    margin-top: 5px;
  }
  </style>
