/**
 * Space Object
 */
class Space {

    constructor(id, html, spaceName, capacity, city, type) {
        this.id = id;
        this.html = html;
        this.space = spaceName;
        this.capacity = capacity;
        this.city = city;
        this.type = type;
    }


    spaceKey() {
        return this.space+'-'+this.city;
    }

}
