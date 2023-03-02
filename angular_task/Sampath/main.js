function person(){
    this.age = 30;
}

let me = new person();
let you = new person();


console.log(me.age);
console.log(person.age)


person.prototype.talk = function(){
    return ("talking");
}


console.log(me.talk());
console.log(you.talk());
