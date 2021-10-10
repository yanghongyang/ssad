document.onreadystatechange = subSomething;
function subSomething() {
//当页面加载状态
if (document.readyState == "complete") {
//延迟一秒关闭loading
$('#sys-loading').delay(500).hide(0);
$('.spinner').delay(500).fadeOut('slow');
}
} 
var vm = new Vue({
  el: '#app',
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
      userID: '',
      imageUrl: '',
      imageURL: '',
      form: {
        

        id:'',
        nickname:'',
        email:'',
        pass:'',
        checkpass:'',
        profile:'',
      },
      tableData: [],
      activeIndex1: '2',
      person_url: './img/person_def.png',
      isAuthSearch: false,
      user_op1:"个人中心",
      }
    },
    
    created () {
      if($.cookie('_PersonUrl')!=null)
      {
          this.person_url=$.cookie('_PersonUrl')
      }   

      if($.cookie('_UserId')!=null)
      {
      this.userID=$.cookie('_UserId');
      console.log(this.userID);
      }
      else{
        window.location.href="index.html"; 
      console.log(error);
      }



      this.getList();
      },

   

    methods: {
      goindex(){
        window.location.href='index.html'
      },
      personal_index(){
        window.location.href = "personal_index.html";
      },
      change_self_info(){
        window.location.href = "change_self_info.html";
      },
      comment_history(){
        window.location.href = "history.html?3";
      },
      collect_history(){
        window.location.href = "history.html?4";
      },
      browse_history(){
        window.location.href = "history.html?1";
      },
      verification(){
        window.location.href = "verification.html?UID="+this.userID;
      },


      handleSelect: function(key, keyPath) {
        //console.log(key, keyPath);
      },
      handleCommand: function(command) {
          if(command=='a')
          {
              if($.cookie('_UserId')!=null)
              {
                  //跳转到个人中心
                  if($.cookie('_UserType')=="3")
                      window.location.href="checkAuth.html"; 
                  else
                      window.location.href="personal_index.html"; 
              }
              else
              {
                  this.loginDialog=true;
              }
          }
          else
          {
              if($.cookie('_UserId')!=null)
              {
                  //logout
                  this.$http.post('logout.php',{userId:$.cookie('_UserId'),},{emulateJSON:true}).then(       
                      function(res){
                          var r=res.body;
                          //console.log(r);
                          if(r==0)
                          {
                              this.$message('退出登录');
                              $.removeCookie('_UserId' ,{path:'/'});
                              $.removeCookie('_UserName' ,{path:'/'});
                              $.removeCookie('_PassWord' ,{path:'/'});
                              $.removeCookie('_UserType' ,{path:'/'});
                              $.removeCookie('_PersonUrl' ,{path:'/'});
                              window.location.href="index.html"; 
                              this.person_url='./img/person_def.png';
                              this.user_op1='登录'
                          }
                          else
                          {
                              this.$message('操作失败，请检测网络状况后重新尝试');
                          }
                      },
                      function(res){console.log(res.status);}
                  );
              }
              else
              {
                  this.$message("未登录")
              }
              
          }
      },
      Reload_index: function(){
          window.location.href="index.html";
      },


      handleAvatarSuccess(res, file) {

        this.$http.post('checkInfo.php',{userID:this.userID},{emulateJSON:true}).then(function(res){
            this.imageUrl = res.body[0].avator;
            //alert(res.body);
            //console.log(this.tableData);
        },function(res){
            console.log(res.status);
            this.$message('请求页面失败');
        });


        //this.imageUrl = URL.createObjectURL(file.raw);

      },
      beforeAvatarUpload(file) {
        const isImg = file.type === 'image/jpeg' || file.type === 'image/png'
        const isLt2M = file.size / 1024 / 1024 < 2
        if (!isImg) {
          this.$message.error('上传头像图片只能是 JPG / PNG 格式!')
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!')
        }
        return isImg && isLt2M
      },

        submitForm(formName) {
          
          var formData = this.form;
          formData.id = this.userID;

          this.$http.post('checkInfo.php',{userID:this.userID},{emulateJSON:true}).then(function(res){
            console.log( $.cookie('_PersonUrl'))
            
            $.removeCookie('_PersonUrl' ,{path:'/'});
            $.cookie('_PersonUrl', res.body[0].avator, { expires: 7 ,path: '/' });
            this.imageURL = $.cookie('_PersonUrl')
            console.log(this.imageURL)

            //alert(res.body);
            //console.log(this.tableData);
          },function(res){
              console.log(res.status);
              this.$message('请求页面失败');
          });


          
          //this.imageURL = $.cookie('_PersonUrl')
          //console.log(this.iamgeURL)


          this.$refs[formName].validate((valid) => {
            if (valid) {
              this.$http.post('updateInfo.php',formData,{emulateJSON:true})
              this.$http.post('updatePwd.php',formData,{emulateJSON:true}).then(function(res){
                console.log(res.body)
                })
              console.log(formData);
            } else {
              console.log('error submit!!');
              this.$message('修改失败');
              return false;
            }
          });


          this.$message('修改成功');
          
        },
        resetForm(formName) {
        this.$refs[formName].resetFields();
        },

        getList () {
          this.$http.post('checkInfo.php',{userID:this.userID},{emulateJSON:true}).then(function(res){
                this.tableData = res.body ;
                //alert(res.body);
                //console.log(this.tableData);
            },function(res){
                console.log(res.status);
                this.$message('请求页面失败');
            });

            

          },

          



      }

})

  







 