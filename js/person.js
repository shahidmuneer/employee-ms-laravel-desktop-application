class person{
    constructor(name){
        this.name=name;
    }
    greetings(){
        return "Hello ! Good Morning "+this.name;
    }
};
console.log(new person("shahid").greetings());