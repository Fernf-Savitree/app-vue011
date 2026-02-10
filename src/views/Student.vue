<template>
  <div class="container mt-4">
    <h2 class="mb-3">รายชื่อนักศึกษา</h2>

<div class= "mb-3 text-end">
    <a class="btn btn-primary" href="/add_student" role="button">Add+</a>
</div>
    
    <!-- ตารางแสดงข้อมูลนักศึกษา -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ลำดับที่</th>
          <th>รหัสนักศึกษา</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>เบอร์โทร</th>
          <th>อีเมล</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(student,index) in students" :key="student.student_id">
          <td>{{ index + 1 }}</td>   <!--แสดงลำดับที่-->
          <td>{{ student.student_id }}</td>
          <td>{{ student.first_name }}</td>
          <td>{{ student.last_name }}</td>
          <td>{{ student.phone }}</td>
          <td>{{ student.email }}</td>
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
  name: "studentList",
  setup() {
    const students = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลจาก API
    const fetchstudents = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/Show_student.php");
        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }
        students.value = await response.json();
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchstudents();
    });

    return {
      students,
      loading,
      error
    };
  }
};
</script>
