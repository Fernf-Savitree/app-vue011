<template>
  <div class="container mt-4 col-md-4 bg-body-secondary ">
    <h2 class="text-center mb-3">ลงทะเบียน</h2>

    <form @submit.prevent="addData">
      <div class="mb-2">
        <input v-model="employee.full_name" class="form-control" placeholder="ชื่อ-นามสกุล" required />
      </div>
      <div class="mb-2">
        <input v-model="employee.department" class="form-control" placeholder="แผนก" required />
      </div>
      <div class="mb-2">
        <input type="number" v-model="employee.salary" class="form-control" placeholder="เงินเดือน" required />
      </div>
           
      <div class="text-center mt-4 ">
      <button type="submit" class="btn btn-primary mb-4">บันทึก</button> &nbsp;
      <button type="reset" class="btn btn-secondary mb-4">ยกเลิก</button>
      </div>
    </form>

    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      employee: {
        full_name: "",
        department: "",
        salary: "",
        active: "1"
      },
      message: ""
    };
  },
  methods: {
    async addData() {
      try {
        const res = await fetch("http://localhost/app-vue011/php_api/add_employee.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(this.employee)
        });
        const data = await res.json();
        this.message = data.message;

        if (data.success) {
          // ✅ เคลียร์ข้อมูลใน textbox หลังบันทึกสำเร็จ
          this.employee = { full_name: "", department: "", salary: "", active: "" };
        }

      } catch (err) {
        this.message = "เกิดข้อผิดพลาด: " + err.message;
      }
    }
  }
}
</script>