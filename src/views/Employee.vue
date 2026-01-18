<template>
  <div class="container mt-4">
    <h2 class="mb-3">ข้อมูลพนักงาน</h2>
    
    <!-- ตารางแสดงประเภทสินค้า -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>รหัสพนักงาน</th>
          <th>ชื่อ-นามสกุล</th>
           <th>แผนก</th>
           <th>เงินเดือน</th>
           <th>สถานะ</th>
           <th>วันที่เพิ่ม</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(employee) in employees" :key="employee.emp_id">
          <td>{{ employee.emp_id }}</td>
          <td>{{ employee.full_name }}</td>
          <td>{{ employee.department }}</td>
          <td>{{ employee.salary }}</td>
          <td>{{ employee.active }}</td>
          <td>{{ employee.created_at }}</td>
                 </tr>
      </tbody>
    </table>

    <!-- Loading -->
    <div v-if="loading" class="text-center">
      <p>กำลังโหลดข้อมูล...</p>
    </div>

    <!-- Error -->
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "employeeList",
  setup() {
    const employees = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลจาก API
    const fetchemployees = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/employee.php");
        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }
        employees.value = await response.json();
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchemployees();
    });

    return {
      employees,
      loading,
      error
    };
  }
};
</script>