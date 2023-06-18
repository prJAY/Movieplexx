const IMGPATH = "https://image.tmdb.org/t/p/w1280";
const SEARCHAPI = "https://api.themoviedb.org/3/search/movie?&api_key=04c35731a5ee918f014970082a0088b1&query=";

const main = document.getElementById("main");
const form = document.getElementById("form");

const search = document.getElementById("name");
const year = document.getElementById("year");

const FINDAPI1 = "https://api.themoviedb.org/3/movie/";
const FINDAPI2 = "?api_key=04c35731a5ee918f014970082a0088b1";

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const searchTerm = search.value;
    const searchyear = year.value;
    if (searchTerm) {
        getMovies(SEARCHAPI + searchTerm + "&primary_release_year=" + searchyear);
    }
});

async function getMovies(url) {
    var resp = await fetch(url);
    var respData = await resp.json();

    //console.log(respData);
    showMovies(respData.results);
}

function showMovies(movies) {

    main.innerHTML = "";

    movies.forEach((movie,index) => {0
        if (index < 5) {
            var searchurl = FINDAPI1 + movie.id + FINDAPI2;
            //console.log(searchurl)
            gettest(searchurl)
        }
    });   
}

async function gettest(url) {
    var resp = await fetch(url);
    var respData = await resp.json();

    //console.log(respData);
    test(respData);
}

function test(movie) {
        //console.log(movie);
        
        const { title, id, overview, release_date, vote_average, poster_path, backdrop_path, runtime, genres, production_companies } = movie;
        const movieEl = document.createElement("div");

        movieEl.classList.add("movie");

        var genre_string  = "/";
        genres.forEach((item) => {0
            genre_string += "/" + item.name;
        });
        genre_string = genre_string.substring(2);

        var production;
        production_companies.forEach((item, index) => {0
            if (index === 0) {
                production = item.name;
            }
        });
        //console.log(genre_string,production);

        movieEl.innerHTML = `
            <form action="/api/movies/insert.php" method="POST">
                <img src="${IMGPATH + poster_path}" alt="${title}" />
                <input type="submit" value="Confirm & Add" class="btn btn-light btnsub" />

                <input name="title" value="${title.replace(/[^a-zA-Z0-9 .]/g, "")}" type="hidden" />
                <input name="studio" value="${production.replace(/[^a-zA-Z0-9 .]/g, "")}" type="hidden" />
                <input name="genres" value="${genre_string.replace(/[^a-zA-Z0-9 .]/g, "")}" type="hidden" />
                <input name="releasedate" value="${release_date}" type="hidden" />
                <input name="tmdb" value="${id}" type="hidden" />
                <input name="overview" value="${overview.replace(/[^a-zA-Z0-9 .]/g, "")}" type="hidden" />
                <input name="runtime" value="${runtime}" type="hidden" />
                <input name="poster" value="${IMGPATH + poster_path}" type="hidden" />
                <input name="banner" value="${IMGPATH + backdrop_path}" type="hidden" />
            </Form>
        `;

        main.appendChild(movieEl);
}