<template>
    <div class="card card-default">
        <div class="card-header">
            <h1 class="m-0 float-left">Book List</h1>
            <a href="/books/create" class="btn btn-primary float-right ml-1" title="Add Book">
                <svg class="i-plus" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M16 2 L16 30 M2 16 L30 16"></path>
                </svg> Add Book
            </a>
            <button @click="toggleSearch" class="btn btn-light float-right ml-1" title="Search" data-toggle="button">
                <svg class="i-search" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <circle cx="14" cy="14" r="12"></circle>
                    <path d="M23 23 L30 30"></path>
                </svg> Search
            </button>
        </div>

        <div v-if="loading" class="card-body">Loading...</div>
        <div v-else-if="books.length">
            <div v-if="showSearch">
                <input v-model="searchQuery" type="text" class="form-control" placeholder="Search..." autofocus="autofocus">
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th v-if="showOrderColumn">Order</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>
                            <a href="#" @click="sortBy('author')">
                                Author
                            </a>
                        </th>
                        <th></th>
                    </tr>
                </thead>

                <draggable v-model="books" :element="'tbody'" @end="onEnd">
                    <tr v-for="(book, index) in filteredBooks" :key="book.id">
                        <td v-if="showOrderColumn" width="50px" class="text-center">
                            <div class="btn-sm btn-outline-dark">
                                <span v-if="book.order">{{ book.order }}<br></span>
                                <svg class="i-move" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                                    <path d="M3 16 L29 16 M16 3 L16 29 M12 7 L16 3 20 7 M12 25 L16 29 20 25 M25 12 L29 16 25 20 M7 12 L3 16 7 20"></path>
                                </svg>
                            </div>
                        </td>
                        <td width="50px">
                            <a :href="'/books/'+book.id">
                                <img v-if="book.image" :src="'/storage/'+book.image" alt="Book Cover" class="img-fluid">
                                <img v-else="book.image" src="http://via.placeholder.com/50x70" alt="No Cover Image" class="img-fluid">
                            </a>
                        </td>
                        <td>
                            <a :href="'/books/'+book.id">
                                {{ book.title }}
                            </a><br>
                            <small class="text-muted">{{ book.publication_date }}</small>
                        </td>
                        <td>{{ book.author }}</td>
                        <td width="25px" class="text-danger">
                            <button @click="deleteBook(book.id)" class="btn btn-sm btn-outline-danger" data-toggle="button">
                                <small>Delete</small><br>
                                <svg class="i-trash" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </draggable>
            </table>
        </div>
        <div v-else class="card-body">
            <p class="alert alert-info">No books. <a href="/books/create">Add one now</a></p>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    
    export default {
        components: {
            draggable,
        },
        data() {
            return {
                books: [],
                loading: false,
                searchQuery: '',
                showSearch: false,
                sortKey: '',
                sortReverse: false,
            }
        },
        computed: {
            filteredBooks() {
                if (this.searchQuery || this.sortKey) {
                    return this.books.filter((book) => {
                        if (this.searchQuery == '') {
                            return true;
                        }
                        let searchTitle = book.title.toLowerCase();
                        let searchAuthor = book.author.toLowerCase();
                        return searchTitle.indexOf(this.searchQuery.toLowerCase()) > -1 || searchAuthor.indexOf(this.searchQuery.toLowerCase()) > -1;
                    }).sort((a,b) => {
                        if (this.sortKey == 'author' && this.sortReverse) {
                            if (a.author < b.author) return 1;
                            if (a.author > b.author) return -1;
                            return 0;
                        } else if (this.sortKey == 'author') {
                            if (a.author < b.author) return -1;
                            if (a.author > b.author) return 1;
                            return 0;
                        }

                        return;
                    });
                }
                
                return this.books;
            },
            showOrderColumn() {
                return this.books.length > 1;
            }
        },
        methods: {
            deleteBook(id) {
                if (window.confirm("Are you sure you want to remove this book?")) { 
                    alert('delete book id ' + id);
                    axios.delete('/api/books/' + id)
                        .then((response) => {
                            this.books = this.books.filter((book) => {
                                return book.id !== id;
                            });
                        }).catch((error) => {
                            alert('Whoops! There was an error deleting the book.');
                        });
                }
            },
            onEnd() {
                this.saveReadingListOrder();
            },
            getBooks() {
                axios.get('/api/books')
                    .then((response) => {
                        this.books = response.data;
                        this.loading = false;
                    }).catch((error) => {
                        alert('Whoops! There was an error getting the books.');
                    });
            },
            saveReadingListOrder() {
                this.loading = true;
                axios.post('/api/reading-list-order', this.books)
                    .then((response) => {
                        this.books = response.data;
                        this.loading = false;
                    });
            },
            sortBy(sortKey) {
                this.sortReverse = (this.sortKey == sortKey) ? !this.sortReverse : false;
                this.sortKey = sortKey;
            },
            toggleSearch() {
                this.showSearch = !this.showSearch;
            }
        },
        created() {
            this.loading = true;
            this.getBooks();
        }
    }
</script>
