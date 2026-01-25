<template>
  <div class="container my-5">
    <!-- หัวข้อหลัก -->
    <h2 class="text-center mb-4">รายการสินค้า</h2>

    <!-- ใช้ Bootstrap แบ่ง row -->
    <div class="row">
      <!-- วน loop แสดงสินค้าแต่ละตัว ด้วย v-for -->
      <div class="col-md-3" v-for="data in Alldata" :key="data.id">

        <!-- card แสดงข้อมูลสินค้า -->
        <div class="card shadow-sm mb-4">
          <!-- แสดงรูปสินค้า โดย path รูปมาจาก server -->
          <img
             :src="'http://localhost/app-vue011/php_api/image/' + data.image"
            width="70%"
            height="300"
            class="card-img-top"
            :alt="data.name"
          >

          <!-- เนื้อหาใน card -->
          <div class="card-body text-center">
            <h5 class="card-title">{{ data.product_name }}</h5> <!-- ชื่อสินค้า -->
            <p class="card-text">{{ data.price }} บาท</p>       <!-- ราคาสินค้า -->
            <button class="btn btn-primary">สั่งซื้อ</button>      <!-- ปุ่มสั่งซื้อ -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "DataList",
  setup() {
    const Alldata = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลจาก API
    const fetchData = async () => {
      try {
        const response = await fetch("http://localhost/app-vue011/php_api/show_product.php");
        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }
        Alldata.value = await response.json();
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchData();
    });

    return {
      Alldata,
      loading,
      error
    };
  }
};
</script>