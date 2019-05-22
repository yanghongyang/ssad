var Main = {
    data() {
        var validatePass = (rule, value, callback) => {
          if (value === '') {
            callback(new Error('请输入密码'));
          } else {
            if (this.form.checkPass !== '') {
              this.$refs.form.validateField('checkPass');
            }
            callback();
          }
        };
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.form.pass) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      
      
      return {
        
      rules2: {
        pass: [
          { validator: validatePass, trigger: 'blur' }
        ],
        checkPass: [
          { validator: validatePass2, trigger: 'blur' }
        ]
      },
      userID: {userID:'1'},
      imageUrl: '',
      form: {
        

        id:'1',
        nickname:'',
        
        email:'',
        profile:'',
      },
      tableData: [],
      }
    },
    
    created () {
      this.getList();
      },

    methods: {
      index(){
        window.location.href = "index.html";
      },
      change_self_info(){
        window.location.href = "change_self_info.html";
      },
      comment_history(){
        window.location.href = "comment_history.html";
      },
      download_history(){
        window.location.href = "download_history.html";
      },
      browse_history(){
        window.location.href = "browse_history.html";
      },

      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isPNG = file.type === 'image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG && isPNG) {
          this.$message.error('上传头像图片只能是 JPG 或 PNG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      },

        submitForm(formName) {
          var formData = this.form;
          var nick = this.form.nickname;
          this.$refs[formName].validate((valid) => {
            if (valid) {
              this.$http.post('updateInfo.php',formData
              ,{emulateJSON:true})
              console.log(formData);
            } else {
              console.log('error submit!!');
              return false;
            }
          });
        },
        resetForm(formName) {
        this.$refs[formName].resetFields();
        },

        getList () {
          this.$http.post('checkInfo.php',{userID:5},{emulateJSON:true}).then(function(res){
                this.tableData = res.body ;
                //alert(res.body);
                //console.log(this.tableData);
            },function(res){
                console.log(res.status);
                this.$message('请求页面失败');
            });

            

          },




      }

}
 
  var Ctor = Vue.extend(Main)
  new Ctor().$mount('#app')







 