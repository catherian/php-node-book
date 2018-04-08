function Queue(content=[]){
    this._queue=[...contents];
}
Queue.prototype.pop=function(){
    const value=this._queue[0];
    this._queue.splice(0,1);
    return value;
}
function PeekableQueue(contents){
    Queue.apply(this,contents);
}
function inherits(Sub,Super){
    var _pro=Object.create(Super.prototype);
    _pro.constructor=Sub;
    Sub.prototype=_pro;
}
inherits(PeekableQueue,Queue);
PeekableQueue.prototype.peek=function(){
    return this._queue[0];
}

// 优化后代码

//best
class Queue {
    constructor(content = []) {
        this._queue = [...content];
    }

    pop() {
        const value = this._queue[0];
        this._queue.splice(0, 1);    
        return value;
    }
}
//good
class PeekableQueue extends Queue{
    peek(){
        return this._queue[0];
    }
}