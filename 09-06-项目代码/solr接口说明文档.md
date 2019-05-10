

## solr接口说明文档

​	为了高效的进行搜索，使用搜索引擎代替SQL语句的搜索。

​	现在后端已经在服务器上部署了solr，并添加了中文分词器和相似匹配模块，实现了如下**两个接口**：

 * 1. **科技成果的标题、摘要检索。**输入需要检索的内容，搜索引擎会进行分词等处理，返回需要的结果。

     例如对于摘要进行检索，搜索“好的算法”，请求的url如下：

      ```php+HTML
      http://www.zdoubleleaves.cn:8080/solr/new_core/select?q=abstract:好的算法
      ```

     会返回包含科技成果id的json：![1557488036400](C:\Users\赵双叶\AppData\Local\Temp\1557488036400.png)

     除了参数q，还可以使用别的参数，用于修改返回的内容等用途。前端同学可以学习一下参数的使用。

     参数的使用参考博客：<https://blog.csdn.net/xiaocai9999/article/details/80385045> 

 * 2. **相似内容的推荐。**安装了MoreLikeThis组件，实现了对于相似内容进行打分排序，可以用于推荐相似的文章。

     输入科技成果的id，可以返回与输入id的科技成果摘要内容相似内容的科技成果列表json。

      例如，对于id=1的科技成果进行相似内容查询，想要返回相似内容的id和得分，请求的url如下：

      ```php+HTML
      http://www.zdoubleleaves.cn:8080/solr/new_core/select?q=id:1&mlt=true&mlt.fl=abstract&mlt.mindf=1&mlt.mintf=1&fl=id,score
      ```

      或

      ```php+HTML
      http://www.zdoubleleaves.cn:8080/solr/new_core/select?q=id:1&mlt=true&mlt.fl=abstract&mlt.mindf=1&mlt.mintf=1&fl=id,score
      ```

![1557488842520](C:\Users\赵双叶\AppData\Local\Temp\1557488842520.png)

​	可以看到上图中的“moreLikeThis”的列表提供了id=12的科技成果。说明id=1的成果和id=12		        的成果内容相似。

![1557489000122](C:\Users\赵双叶\AppData\Local\Temp\1557489000122.png)

​		这是数据库科技成果表的内容，可以看到第1行和第12行的anstract列的内容较相似。

​		除了请求url的实例中的参数，mlt也有很多参数，用于修改搜索的要求和返回的内容。

​		参数的使用参考博客：<https://www.cnblogs.com/langfanyun/p/7490525.html> 或solrMLT文档