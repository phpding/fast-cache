//js树形查找

 function getName(arr, id) {

        var num = arr.length;

        for (var i = 0; i < num; i++) {
            if (arr[i].id == id) {
                return arr[i].name
            } else {
                if (arr[i].children) {
                    var name = getName(arr[i].children, id)
                    if(name){
                        return name;
                    }
                }
            }
        }
        return ''
    }

    var trees = [
        {
            id: 1,
            name: 'a',
            children: [
                {
                    id: 4,
                    name: 'b'
                },
                {
                    id: 5,
                    name: 'd'
                }

            ]
        },
        {
            id: 6,
            name: 'aa',
            children: [
                {
                    id: 7,
                    name: 'bb'
                },
                {
                    id: 8,
                    name: 'dd'
                }

            ]
        },
        {
            id: 2,
            name: 'b',
            children: []
        },
        {
            id: 3,
            name: 'd',
            children: []
        }
    ]

    console.log(getName(trees, 8))

    console.log(getName(trees, 5))
