//alert("Hello, from our new JS file")

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention",{
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    edit: function (){
        return wp.element.createElement("h3",null, "Hello, this is from the admin editor screen")
    },
    save: function (){

    }
})