```
小程序端
// pages/chat/chat.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    msgList: [],
    newMsg: "",
    my: "zhengwen",
    to: "zhonzhon"
  },



  /**
   * 生命周期函数--监听页面加载
   */
  onLoad(options) {
    this.openSocket();
  },
  clickSubmit() {
    let newMsg = this.data.newMsg;
    let list = this.data.msgList;
    console.log(1111);
    let msg = {
      'type': "send",
      'my': this.data.my,
      'to': this.data.to,
      'msg': newMsg
    };
    this.sendMsg(msg);
    list = list.concat(msg);
    this.setData({
      msgList:list
    })
    console.log(this.data.msgList);
  },
  linkInput(res) {
    this.setData({
      newMsg: res.detail.value
    })
  },
  openSocket() {
    wx.connectSocket({
      url: 'ws://110.40.207.218:9502',
      success: res => {
        wx.onSocketOpen((result) => {
          console.log(result);
          let msg = {
            'type': "open",
            'my': this.data.my
          };
          this.sendMsg(msg);
          this.onSockectMessage();
        })
      }
    })
  },

  sendMsg(res) {
    res = JSON.stringify(res);
    wx.sendSocketMessage({
      data: res,
    })
  },

  onSockectMessage() {
    wx.onSocketMessage((result) => {
      let newMsg = JSON.parse(result.data);
      let oldMsg = this.data.msgList;
      oldMsg = oldMsg.concat(newMsg);
      this.setData({
        msgList:oldMsg
      });
      console.log(oldMsg);
    })
  },




  clickOut() {
    wx.closeSocket({
      success: res => {
        console.log('退出成功');
      }
    })
  }
})
```

```
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