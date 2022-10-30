```
小程序端
Page({

    /**
     * 页面的初始数据
     */
    data: {
        list: []
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {


        this.setData({
            id:options.id
        })




        this.websocketXin();
        var that = this
        wx.connectSocket({
            url: 'ws://8.141.163.251:9502',
            success: function (res) {
                wx.onSocketOpen((result) => {
                    var send = {
                        'my': 'a',
                        'to': 'b',
                        'type': 'open'
                    };
                    that.send(JSON.stringify(send))
                })
            }
        })
        wx.onSocketMessage((result) => {
            console.log(result.data)
            var list = this.data.list
            var arr = {
                'class': 'you',
                'msg': result.data
            }
            list.push(arr);
            this.setData({
                list: list
            })
        })
    },

    send: function (data) {
        wx.sendSocketMessage({
            data: data,
        })
    },
    txt: function (res) {
        this.setData({
            txt: res.detail.value
        })
    },
    btn: function (res) {
        var txt = this.data.txt
        var that = this 

        var send = {
            'my': 'a',
            'to': 'b',
            'type': 'send',
            'msg': txt
        }


        var list = this.data.list
        list.push({
            'class': 'my',
            'msg': txt
        });
        this.setData({
            list: list
        })
        console.log(this.data.list)
        this.send(JSON.stringify(send));
    },
    websocketXin: function () {
        var that = this
        var send = {
            'my': 'a',
            'type': 'xin',
        }
        var time = setInterval(() => {
            this.send(JSON.stringify(send))
            console.log('当前心跳已重新链接')
        },50000);
    },
    close:function()
    {
        wx.closeSocket({
          code: 1000,
        })
        wx.reLaunch({
            url: '/pages/index/index',
          })
    },
    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function () {

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {

    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function () {

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function () {

    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function () {

    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function () {

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function () {

    }
})
```

```angular2html
服务端
 <?php
//创建WebSocket Server对象，监听0.0.0.0:9502端口
$ws = new Swoole\WebSocket\Server('0.0.0.0', 9502);
$redis = new Redis();
$redis->connect('127.0.0.1','6379');


//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) {
    $ws->push($request->fd, "hello, welcome\n");
});
//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame)use($redis){
    
    $data = json_decode($frame->data,true);
    
    switch ($data['type']) {
        case 'open':
           $redis->set($data['my'],$frame->fd);
            break;
        case 'send':
            $to = $redis->get($data['to']);
            // print_r($data);
             $msg = [
                'msg'=>$data['data']
                ];
            $ws->push($to,json_encode($msg,true));
            break;
            
            
        default:
            break;
    }
    $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('Close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();
```