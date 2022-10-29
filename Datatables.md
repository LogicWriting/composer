laraval8 datatables 渲染页面 分页 显示按钮


1.引入datatables css js cdn 链接

   <!--第一步：引入Javascript / CSS （CDN）-->
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
 
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
 
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
2.提前布局要展示的页面 注意数据库查出的数据无需写html标签

<!--第二步：添加如下 HTML 代码-->
```
<table id="table_id_example" class="display">
    <thead>
    <tr>
        <th>ID</th>
        <th>医生姓名</th>
        <th>医生照片</th>
        <td>院区</td>
        <td>职称</td>
        <td>科室</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
```
3.初始化datatables

<!--第三步：初始化Datatables-->
```
$(document).ready( function () {
$('#table_id_example').DataTable({
// 开启分页
paging:true,

        // scrollY:500,
        //每页显示条数
        lengthMenu:[3,5,7,10],
        //开启服务器模式
        serverSide: true,

        //后端请求
        ajax:{
            url:'{{route('admin.doctor.datatables')}}',
            type:'get'
        },
        //需要展示页面的数据
        columns:[
            {data:'id'},
            {data:'doctor_name'},
            {data:'doctor_img'},
            {data:'campus_id'},
            {data:'departmenthome_id'},
            {data:'doctor_position_id'},
            {data:'introduce'},

        ]

    });
});
```
4.后端代码 实现渲染分页
```
//datatables 渲染页面
public function datatables(Request $request)
{
//查询数据库数据
$data = DoctorModel::all();
//记录总条数
$total = $data->count();
//分页开始的位置
$start = $request->get('start');
//分页结束的位置
$length = $request->get('length');
//接收要搜索的数据
$search = $request->get('search',[]);
//分页
$data = DoctorModel::offset($start)->limit($length)->get();
//datatables 返回参数必选 一下四个
$result = [
'draw'=>$request->get('draw'),
'recordsTotal'=>$total,
'recordsFiltered'=>$total,
'data'=>$data
];
return $result;

}
datatables显示按钮 比如说 删除按钮 详情 编辑等按钮

我们就需要用到laravel8 的模型访问器

<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Firm extends Model
{
    use HasFactory;
    // 追加字段 ， 显示按钮
    protected $appends = ['operate'];
 
    // 访问器 getOperateAttribute get为固定 Operate自己定义的名称
    public function getOperateAttribute()
    {
        $id = $this->id;
        return "<a href='http://www.king.com/index.php/select?id=$id'>查看</a>"."<a href='http://www.king.com/index.php/select?id=$id'>修改</a>"."<a href='http://www.king.com/index.php/select?id=$id'>删除</a>";
    }
 
```
