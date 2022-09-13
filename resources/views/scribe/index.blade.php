<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var baseUrl = "http://wahtermelon.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.0.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.0.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-login">
                                <a href="#endpoints-POSTapi-v1-login">User Login API</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-register">
                                <a href="#endpoints-POSTapi-v1-register">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-patient">
                                <a href="#endpoints-GETapi-v1-patient">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-patient">
                                <a href="#endpoints-POSTapi-v1-patient">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-regions">
                                <a href="#endpoints-GETapi-v1-libraries-regions">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-regions--region_code-">
                                <a href="#endpoints-GETapi-v1-libraries-regions--region_code-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-provinces">
                                <a href="#endpoints-GETapi-v1-libraries-provinces">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-provinces--province_code-">
                                <a href="#endpoints-GETapi-v1-libraries-provinces--province_code-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-municipalities">
                                <a href="#endpoints-GETapi-v1-libraries-municipalities">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-municipalities--municipality_code-">
                                <a href="#endpoints-GETapi-v1-libraries-municipalities--municipality_code-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-barangays">
                                <a href="#endpoints-GETapi-v1-libraries-barangays">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-barangays--barangay_code-">
                                <a href="#endpoints-GETapi-v1-libraries-barangays--barangay_code-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-facilities">
                                <a href="#endpoints-GETapi-v1-libraries-facilities">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-facilities--facility_facility_code-">
                                <a href="#endpoints-GETapi-v1-libraries-facilities--facility_facility_code-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-civil-statuses">
                                <a href="#endpoints-GETapi-v1-libraries-civil-statuses">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-civil-statuses--id-">
                                <a href="#endpoints-GETapi-v1-libraries-civil-statuses--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-education">
                                <a href="#endpoints-GETapi-v1-libraries-education">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-education--id-">
                                <a href="#endpoints-GETapi-v1-libraries-education--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-occupation-categories">
                                <a href="#endpoints-GETapi-v1-libraries-occupation-categories">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-occupation-categories--id-">
                                <a href="#endpoints-GETapi-v1-libraries-occupation-categories--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-occupations">
                                <a href="#endpoints-GETapi-v1-libraries-occupations">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-occupations--id-">
                                <a href="#endpoints-GETapi-v1-libraries-occupations--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-pwd-types">
                                <a href="#endpoints-GETapi-v1-libraries-pwd-types">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-pwd-types--id-">
                                <a href="#endpoints-GETapi-v1-libraries-pwd-types--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-religions">
                                <a href="#endpoints-GETapi-v1-libraries-religions">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-religions--id-">
                                <a href="#endpoints-GETapi-v1-libraries-religions--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-suffix-names">
                                <a href="#endpoints-GETapi-v1-libraries-suffix-names">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-libraries-suffix-names--id-">
                                <a href="#endpoints-GETapi-v1-libraries-suffix-names--id-">Display the specified resource.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-libraries-for-patient-module" class="tocify-header">
                <li class="tocify-item level-1" data-unique="libraries-for-patient-module">
                    <a href="#libraries-for-patient-module">Libraries for Patient Module</a>
                </li>
                                    <ul id="tocify-subheader-libraries-for-patient-module" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="libraries-for-patient-module-blood-type">
                                <a href="#libraries-for-patient-module-blood-type">Blood Type</a>
                            </li>
                                                            <ul id="tocify-subheader-libraries-for-patient-module-blood-type" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="libraries-for-patient-module-GETapi-v1-libraries-blood-types">
                                            <a href="#libraries-for-patient-module-GETapi-v1-libraries-blood-types">Display a listing of the resource.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="libraries-for-patient-module-GETapi-v1-libraries-blood-types--bloodType_blood_type-">
                                            <a href="#libraries-for-patient-module-GETapi-v1-libraries-blood-types--bloodType_blood_type-">Display the specified resource.</a>
                                        </li>
                                                                    </ul>
                                                                        </ul>
                            </ul>
            </div>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
        <ul class="toc-footer" id="last-updated">
        <li>Last updated: September 13 2022</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://wahtermelon.test</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user"></code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-login">User Login API</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://wahtermelon.test/api/v1/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"kristin27@example.net\",
    \"password\": \"modi\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "kristin27@example.net",
    "password": "modi"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-login">
</span>
<span id="execution-results-POSTapi-v1-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-login"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-login"></code></pre>
</span>
<form id="form-POSTapi-v1-login" data-method="POST"
      data-path="api/v1/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-login"
                    onclick="tryItOut('POSTapi-v1-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-login"
                    onclick="cancelTryOut('POSTapi-v1-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-login" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/login</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-v1-login"
               value="kristin27@example.net"
               data-component="body" hidden>
    <br>
<p>Must be a valid email address.</p>
        </p>
                <p>
            <b><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="password"
               data-endpoint="POSTapi-v1-login"
               value="modi"
               data-component="body" hidden>
    <br>

        </p>
        </form>

                    <h2 id="endpoints-POSTapi-v1-register">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://wahtermelon.test/api/v1/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"last_name\": \"dolores\",
    \"first_name\": \"nostrum\",
    \"suffix_name\": \"rem\",
    \"gender\": \"sit\",
    \"birthdate\": \"2022-09-13T14:33:40\",
    \"contact_number\": \"oamnip\",
    \"email\": \"smith.kody@example.net\",
    \"tin_number\": \"na\",
    \"accreditation_number\": \"dxalkafjaj\",
    \"password\": \"fuga\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "last_name": "dolores",
    "first_name": "nostrum",
    "suffix_name": "rem",
    "gender": "sit",
    "birthdate": "2022-09-13T14:33:40",
    "contact_number": "oamnip",
    "email": "smith.kody@example.net",
    "tin_number": "na",
    "accreditation_number": "dxalkafjaj",
    "password": "fuga"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-register">
</span>
<span id="execution-results-POSTapi-v1-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-register"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-register"></code></pre>
</span>
<form id="form-POSTapi-v1-register" data-method="POST"
      data-path="api/v1/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-register"
                    onclick="tryItOut('POSTapi-v1-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-register"
                    onclick="cancelTryOut('POSTapi-v1-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-register" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/register</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="last_name"
               data-endpoint="POSTapi-v1-register"
               value="dolores"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="first_name"
               data-endpoint="POSTapi-v1-register"
               value="nostrum"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>middle_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="middle_name"
               data-endpoint="POSTapi-v1-register"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>suffix_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="suffix_name"
               data-endpoint="POSTapi-v1-register"
               value="rem"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="POSTapi-v1-register"
               value="sit"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>birthdate</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="birthdate"
               data-endpoint="POSTapi-v1-register"
               value="2022-09-13T14:33:40"
               data-component="body" hidden>
    <br>
<p>Must be a valid date.</p>
        </p>
                <p>
            <b><code>contact_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="contact_number"
               data-endpoint="POSTapi-v1-register"
               value="oamnip"
               data-component="body" hidden>
    <br>
<p>Must be at least 11 characters. Must not be greater than 13 characters.</p>
        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-v1-register"
               value="smith.kody@example.net"
               data-component="body" hidden>
    <br>
<p>Must be a valid email address.</p>
        </p>
                <p>
            <b><code>is_active</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="is_active"
               data-endpoint="POSTapi-v1-register"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>photo_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="photo_url"
               data-endpoint="POSTapi-v1-register"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>tin_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="tin_number"
               data-endpoint="POSTapi-v1-register"
               value="na"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 9 characters.</p>
        </p>
                <p>
            <b><code>accreditation_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="accreditation_number"
               data-endpoint="POSTapi-v1-register"
               value="dxalkafjaj"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 14 characters.</p>
        </p>
                <p>
            <b><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="password"
               data-endpoint="POSTapi-v1-register"
               value="fuga"
               data-component="body" hidden>
    <br>

        </p>
        </form>

                    <h2 id="endpoints-GETapi-v1-patient">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-patient">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/patient" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/patient"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-patient">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 32
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;last_name&quot;: &quot;Considine&quot;,
            &quot;first_name&quot;: &quot;Harmon&quot;,
            &quot;middle_name&quot;: &quot;Osinski&quot;,
            &quot;suffix_code&quot;: &quot;SR&quot;,
            &quot;birthdate&quot;: &quot;1997-02-06&quot;,
            &quot;mothers_name&quot;: &quot;Cassidy Osinski&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;505-244-220&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;A+&quot;,
            &quot;religion_code&quot;: &quot;JEWIT&quot;,
            &quot;occupation_code&quot;: &quot;FOOD004&quot;,
            &quot;education_id&quot;: 1,
            &quot;civil_status_id&quot;: &quot;ANLD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 16:53:47&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 16:53:47&quot;
        },
        {
            &quot;last_name&quot;: &quot;Davis&quot;,
            &quot;first_name&quot;: &quot;Jerrod&quot;,
            &quot;middle_name&quot;: &quot;Okuneva&quot;,
            &quot;suffix_code&quot;: &quot;II&quot;,
            &quot;birthdate&quot;: &quot;2003-03-18&quot;,
            &quot;mothers_name&quot;: &quot;Opal Okuneva&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;846-335-358&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;O+&quot;,
            &quot;religion_code&quot;: &quot;WESLY&quot;,
            &quot;occupation_code&quot;: &quot;UNSP006&quot;,
            &quot;education_id&quot;: 6,
            &quot;civil_status_id&quot;: &quot;MRRD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 17:01:31&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 17:01:31&quot;
        },
        {
            &quot;last_name&quot;: &quot;Dibbert&quot;,
            &quot;first_name&quot;: &quot;Celine&quot;,
            &quot;middle_name&quot;: &quot;Nolan&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1979-02-21&quot;,
            &quot;mothers_name&quot;: &quot;Carmella Nolan&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;534-990-755&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;NA&quot;,
            &quot;religion_code&quot;: &quot;IGNIK&quot;,
            &quot;occupation_code&quot;: &quot;SVC036&quot;,
            &quot;education_id&quot;: 1,
            &quot;civil_status_id&quot;: &quot;MRRD&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-13 07:58:28&quot;,
            &quot;updated_at&quot;: &quot;2022-09-13 07:58:28&quot;
        },
        {
            &quot;last_name&quot;: &quot;Emmerich&quot;,
            &quot;first_name&quot;: &quot;Chelsea&quot;,
            &quot;middle_name&quot;: &quot;Hammes&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;2002-10-16&quot;,
            &quot;mothers_name&quot;: &quot;Henriette Hammes&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;489-523-848&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;A+&quot;,
            &quot;religion_code&quot;: &quot;EVANG&quot;,
            &quot;occupation_code&quot;: &quot;FOOD003&quot;,
            &quot;education_id&quot;: 1,
            &quot;civil_status_id&quot;: &quot;MRRD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 15:10:48&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 15:10:48&quot;
        },
        {
            &quot;last_name&quot;: &quot;Kihn&quot;,
            &quot;first_name&quot;: &quot;Johnpaul&quot;,
            &quot;middle_name&quot;: &quot;Kuphal&quot;,
            &quot;suffix_code&quot;: &quot;IV&quot;,
            &quot;birthdate&quot;: &quot;1984-07-22&quot;,
            &quot;mothers_name&quot;: &quot;Etha Kuphal&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;123-412-623&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;O+&quot;,
            &quot;religion_code&quot;: &quot;METOD&quot;,
            &quot;occupation_code&quot;: &quot;SVC014&quot;,
            &quot;education_id&quot;: 8,
            &quot;civil_status_id&quot;: &quot;MRRD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 15:10:30&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 15:10:30&quot;
        },
        {
            &quot;last_name&quot;: &quot;Larkin&quot;,
            &quot;first_name&quot;: &quot;Jordane&quot;,
            &quot;middle_name&quot;: &quot;Boyle&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1978-12-30&quot;,
            &quot;mothers_name&quot;: &quot;Kaitlyn Boyle&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;310-190-797&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;NA&quot;,
            &quot;religion_code&quot;: &quot;BAPTI&quot;,
            &quot;occupation_code&quot;: &quot;SVC025&quot;,
            &quot;education_id&quot;: 5,
            &quot;civil_status_id&quot;: &quot;CHBTN&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 14:42:01&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 14:42:01&quot;
        },
        {
            &quot;last_name&quot;: &quot;Lehner&quot;,
            &quot;first_name&quot;: &quot;Karen&quot;,
            &quot;middle_name&quot;: &quot;Crona&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1989-08-27&quot;,
            &quot;mothers_name&quot;: &quot;Trinity Crona&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;877-037-580&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;O+&quot;,
            &quot;religion_code&quot;: &quot;XTIAN&quot;,
            &quot;occupation_code&quot;: &quot;HEALTH003&quot;,
            &quot;education_id&quot;: 7,
            &quot;civil_status_id&quot;: &quot;ANLD&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-13 10:40:14&quot;,
            &quot;updated_at&quot;: &quot;2022-09-13 10:40:14&quot;
        },
        {
            &quot;last_name&quot;: &quot;Lesch&quot;,
            &quot;first_name&quot;: &quot;Olin&quot;,
            &quot;middle_name&quot;: &quot;Streich&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;2012-05-27&quot;,
            &quot;mothers_name&quot;: &quot;Juana Streich&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;642-971-585&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;A+&quot;,
            &quot;religion_code&quot;: &quot;BAPTI&quot;,
            &quot;occupation_code&quot;: &quot;SVC008&quot;,
            &quot;education_id&quot;: 5,
            &quot;civil_status_id&quot;: &quot;CHBTN&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-13 07:58:28&quot;,
            &quot;updated_at&quot;: &quot;2022-09-13 07:58:28&quot;
        },
        {
            &quot;last_name&quot;: &quot;Mosciski&quot;,
            &quot;first_name&quot;: &quot;Bethel&quot;,
            &quot;middle_name&quot;: &quot;O&#039;connell&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1993-06-19&quot;,
            &quot;mothers_name&quot;: &quot;Adeline O&#039;connell&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;457-913-687&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;B-&quot;,
            &quot;religion_code&quot;: &quot;BRNAG&quot;,
            &quot;occupation_code&quot;: &quot;SVC030&quot;,
            &quot;education_id&quot;: 2,
            &quot;civil_status_id&quot;: &quot;MRRD&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 16:53:47&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 16:53:47&quot;
        },
        {
            &quot;last_name&quot;: &quot;Pfannerstill&quot;,
            &quot;first_name&quot;: &quot;Kaia&quot;,
            &quot;middle_name&quot;: &quot;Rosenbaum&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1989-04-25&quot;,
            &quot;mothers_name&quot;: &quot;Vivienne Rosenbaum&quot;,
            &quot;gender&quot;: &quot;F&quot;,
            &quot;mobile_number&quot;: &quot;074-410-327&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;AB-&quot;,
            &quot;religion_code&quot;: &quot;MORMO&quot;,
            &quot;occupation_code&quot;: &quot;SVC030&quot;,
            &quot;education_id&quot;: 7,
            &quot;civil_status_id&quot;: &quot;WDWD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 14:42:02&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 14:42:02&quot;
        },
        {
            &quot;last_name&quot;: &quot;Prohaska&quot;,
            &quot;first_name&quot;: &quot;Emiliano&quot;,
            &quot;middle_name&quot;: &quot;Thompson&quot;,
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;birthdate&quot;: &quot;1999-11-26&quot;,
            &quot;mothers_name&quot;: &quot;Minnie Thompson&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;642-278-283&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;B-&quot;,
            &quot;religion_code&quot;: &quot;XTIAN&quot;,
            &quot;occupation_code&quot;: &quot;HEALTH005&quot;,
            &quot;education_id&quot;: 2,
            &quot;civil_status_id&quot;: &quot;WDWD&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 15:10:29&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 15:10:29&quot;
        },
        {
            &quot;last_name&quot;: &quot;Rice&quot;,
            &quot;first_name&quot;: &quot;Jaiden&quot;,
            &quot;middle_name&quot;: &quot;Ratke&quot;,
            &quot;suffix_code&quot;: &quot;V&quot;,
            &quot;birthdate&quot;: &quot;1974-12-19&quot;,
            &quot;mothers_name&quot;: &quot;Delia Ratke&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;668-071-313&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;B+&quot;,
            &quot;religion_code&quot;: &quot;BRNAG&quot;,
            &quot;occupation_code&quot;: &quot;SVC028&quot;,
            &quot;education_id&quot;: 4,
            &quot;civil_status_id&quot;: &quot;SPRTD&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-13 10:40:14&quot;,
            &quot;updated_at&quot;: &quot;2022-09-13 10:40:14&quot;
        },
        {
            &quot;last_name&quot;: &quot;Tromp&quot;,
            &quot;first_name&quot;: &quot;Hilton&quot;,
            &quot;middle_name&quot;: &quot;Goyette&quot;,
            &quot;suffix_code&quot;: &quot;JR&quot;,
            &quot;birthdate&quot;: &quot;2003-11-02&quot;,
            &quot;mothers_name&quot;: &quot;Sandrine Goyette&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;868-380-408&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: true,
            &quot;blood_type&quot;: &quot;B+&quot;,
            &quot;religion_code&quot;: &quot;PENTE&quot;,
            &quot;occupation_code&quot;: &quot;SVC027&quot;,
            &quot;education_id&quot;: 4,
            &quot;civil_status_id&quot;: &quot;ANLD&quot;,
            &quot;consent_flag&quot;: false,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 17:01:31&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 17:01:31&quot;
        },
        {
            &quot;last_name&quot;: &quot;Wiegand&quot;,
            &quot;first_name&quot;: &quot;Dax&quot;,
            &quot;middle_name&quot;: &quot;Windler&quot;,
            &quot;suffix_code&quot;: &quot;IV&quot;,
            &quot;birthdate&quot;: &quot;2002-12-26&quot;,
            &quot;mothers_name&quot;: &quot;Ona Windler&quot;,
            &quot;gender&quot;: &quot;M&quot;,
            &quot;mobile_number&quot;: &quot;291-148-926&quot;,
            &quot;pwd_status_code&quot;: null,
            &quot;indegenous_flag&quot;: false,
            &quot;blood_type&quot;: &quot;B-&quot;,
            &quot;religion_code&quot;: &quot;JEWIT&quot;,
            &quot;occupation_code&quot;: &quot;HEALTH014&quot;,
            &quot;education_id&quot;: 1,
            &quot;civil_status_id&quot;: &quot;CHBTN&quot;,
            &quot;consent_flag&quot;: true,
            &quot;image_url&quot;: null,
            &quot;created_at&quot;: &quot;2022-09-12 15:10:48&quot;,
            &quot;updated_at&quot;: &quot;2022-09-12 15:10:48&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/patient?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/patient?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/patient?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/patient&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 14,
        &quot;total&quot;: 14
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-patient" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-patient"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-patient"></code></pre>
</span>
<span id="execution-error-GETapi-v1-patient" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-patient"></code></pre>
</span>
<form id="form-GETapi-v1-patient" data-method="GET"
      data-path="api/v1/patient"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-patient', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-patient"
                    onclick="tryItOut('GETapi-v1-patient');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-patient"
                    onclick="cancelTryOut('GETapi-v1-patient');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-patient" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/patient</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-patient">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-patient">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://wahtermelon.test/api/v1/patient" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"last_name\": \"omnis\",
    \"first_name\": \"sapiente\",
    \"suffix_name\": \"sequi\",
    \"birthdate\": \"2010-03-05\",
    \"mothers_name\": \"sit\",
    \"gender\": \"excepturi\",
    \"mobile_number\": \"e\",
    \"indegenous_flag\": false,
    \"religion_code\": \"expedita\",
    \"occupation_code\": \"unde\",
    \"education_id\": \"blanditiis\",
    \"civil_status_id\": \"libero\",
    \"consent_flag\": true,
    \"image_url\": \"http:\\/\\/www.mitchell.biz\\/quam-modi-porro-delectus.html\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/patient"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "last_name": "omnis",
    "first_name": "sapiente",
    "suffix_name": "sequi",
    "birthdate": "2010-03-05",
    "mothers_name": "sit",
    "gender": "excepturi",
    "mobile_number": "e",
    "indegenous_flag": false,
    "religion_code": "expedita",
    "occupation_code": "unde",
    "education_id": "blanditiis",
    "civil_status_id": "libero",
    "consent_flag": true,
    "image_url": "http:\/\/www.mitchell.biz\/quam-modi-porro-delectus.html"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-patient">
</span>
<span id="execution-results-POSTapi-v1-patient" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-patient"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-patient"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-patient" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-patient"></code></pre>
</span>
<form id="form-POSTapi-v1-patient" data-method="POST"
      data-path="api/v1/patient"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-patient', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-patient"
                    onclick="tryItOut('POSTapi-v1-patient');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-patient"
                    onclick="cancelTryOut('POSTapi-v1-patient');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-patient" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/patient</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>facility_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="facility_id"
               data-endpoint="POSTapi-v1-patient"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="last_name"
               data-endpoint="POSTapi-v1-patient"
               value="omnis"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="first_name"
               data-endpoint="POSTapi-v1-patient"
               value="sapiente"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>middle_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="middle_name"
               data-endpoint="POSTapi-v1-patient"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>suffix_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="suffix_name"
               data-endpoint="POSTapi-v1-patient"
               value="sequi"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>birthdate</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="birthdate"
               data-endpoint="POSTapi-v1-patient"
               value="2010-03-05"
               data-component="body" hidden>
    <br>
<p>Must be a valid date. Must be a valid date in the format <code>Y-m-d</code>. Must be a date before <code>tomorrow</code>.</p>
        </p>
                <p>
            <b><code>mothers_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="mothers_name"
               data-endpoint="POSTapi-v1-patient"
               value="sit"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="POSTapi-v1-patient"
               value="excepturi"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>mobile_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="mobile_number"
               data-endpoint="POSTapi-v1-patient"
               value="e"
               data-component="body" hidden>
    <br>
<p>Must be at least 11 characters. Must not be greater than 13 characters.</p>
        </p>
                <p>
            <b><code>pwd_status_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="pwd_status_code"
               data-endpoint="POSTapi-v1-patient"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>indegenous_flag</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-patient" hidden>
            <input type="radio" name="indegenous_flag"
                   value="true"
                   data-endpoint="POSTapi-v1-patient"
                   data-component="body"
            >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-patient" hidden>
            <input type="radio" name="indegenous_flag"
                   value="false"
                   data-endpoint="POSTapi-v1-patient"
                   data-component="body"
            >
            <code>false</code>
        </label>
    <br>

        </p>
                <p>
            <b><code>blood_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="blood_type"
               data-endpoint="POSTapi-v1-patient"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>religion_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="religion_code"
               data-endpoint="POSTapi-v1-patient"
               value="expedita"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>occupation_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="occupation_code"
               data-endpoint="POSTapi-v1-patient"
               value="unde"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>education_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="education_id"
               data-endpoint="POSTapi-v1-patient"
               value="blanditiis"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>civil_status_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="civil_status_id"
               data-endpoint="POSTapi-v1-patient"
               value="libero"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>consent_flag</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-patient" hidden>
            <input type="radio" name="consent_flag"
                   value="true"
                   data-endpoint="POSTapi-v1-patient"
                   data-component="body"
            >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-patient" hidden>
            <input type="radio" name="consent_flag"
                   value="false"
                   data-endpoint="POSTapi-v1-patient"
                   data-component="body"
            >
            <code>false</code>
        </label>
    <br>

        </p>
                <p>
            <b><code>image_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text"
               name="image_url"
               data-endpoint="POSTapi-v1-patient"
               value="http://www.mitchell.biz/quam-modi-porro-delectus.html"
               data-component="body" hidden>
    <br>
<p>Must be a valid URL.</p>
        </p>
        </form>

                    <h2 id="endpoints-GETapi-v1-libraries-regions">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-regions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/regions" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/regions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-regions">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 31
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;code&quot;: &quot;010000000&quot;,
            &quot;name&quot;: &quot;Region I (Ilocos Region)&quot;,
            &quot;population&quot;: 5301139
        },
        {
            &quot;code&quot;: &quot;020000000&quot;,
            &quot;name&quot;: &quot;Region II (Cagayan Valley)&quot;,
            &quot;population&quot;: 3685744
        },
        {
            &quot;code&quot;: &quot;030000000&quot;,
            &quot;name&quot;: &quot;Region III (Central Luzon)&quot;,
            &quot;population&quot;: 12422172
        },
        {
            &quot;code&quot;: &quot;040000000&quot;,
            &quot;name&quot;: &quot;Region IV-A (CALABARZON)&quot;,
            &quot;population&quot;: 16195042
        },
        {
            &quot;code&quot;: &quot;170000000&quot;,
            &quot;name&quot;: &quot;MIMAROPA Region&quot;,
            &quot;population&quot;: 3228558
        },
        {
            &quot;code&quot;: &quot;050000000&quot;,
            &quot;name&quot;: &quot;Region V (Bicol Region)&quot;,
            &quot;population&quot;: 6082165
        },
        {
            &quot;code&quot;: &quot;060000000&quot;,
            &quot;name&quot;: &quot;Region VI (Western Visayas)&quot;,
            &quot;population&quot;: 7954723
        },
        {
            &quot;code&quot;: &quot;070000000&quot;,
            &quot;name&quot;: &quot;Region VII (Central Visayas)&quot;,
            &quot;population&quot;: 8081988
        },
        {
            &quot;code&quot;: &quot;080000000&quot;,
            &quot;name&quot;: &quot;Region VIII (Eastern Visayas)&quot;,
            &quot;population&quot;: 4547150
        },
        {
            &quot;code&quot;: &quot;090000000&quot;,
            &quot;name&quot;: &quot;Region IX (Zamboanga Peninsula)&quot;,
            &quot;population&quot;: 3875576
        },
        {
            &quot;code&quot;: &quot;100000000&quot;,
            &quot;name&quot;: &quot;Region X (Northern Mindanao)&quot;,
            &quot;population&quot;: 5022768
        },
        {
            &quot;code&quot;: &quot;110000000&quot;,
            &quot;name&quot;: &quot;Region XI (Davao Region)&quot;,
            &quot;population&quot;: 5243536
        },
        {
            &quot;code&quot;: &quot;120000000&quot;,
            &quot;name&quot;: &quot;Region XII (SOCCSKSARGEN)&quot;,
            &quot;population&quot;: 4901486
        },
        {
            &quot;code&quot;: &quot;130000000&quot;,
            &quot;name&quot;: &quot;National Capital Region (NCR)&quot;,
            &quot;population&quot;: 13484462
        },
        {
            &quot;code&quot;: &quot;140000000&quot;,
            &quot;name&quot;: &quot;Cordillera Administrative Region (CAR)&quot;,
            &quot;population&quot;: 1797660
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=2&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 2,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/libraries/regions&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 17
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-regions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-regions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-regions"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-regions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-regions"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-regions" data-method="GET"
      data-path="api/v1/libraries/regions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-regions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-regions"
                    onclick="tryItOut('GETapi-v1-libraries-regions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-regions"
                    onclick="cancelTryOut('GETapi-v1-libraries-regions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-regions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/regions</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-regions--region_code-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-regions--region_code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/regions/010000000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/regions/010000000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-regions--region_code-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 30
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\PSGC\\Region] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-regions--region_code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-regions--region_code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-regions--region_code-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-regions--region_code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-regions--region_code-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-regions--region_code-" data-method="GET"
      data-path="api/v1/libraries/regions/{region_code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-regions--region_code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-regions--region_code-"
                    onclick="tryItOut('GETapi-v1-libraries-regions--region_code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-regions--region_code-"
                    onclick="cancelTryOut('GETapi-v1-libraries-regions--region_code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-regions--region_code-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/regions/{region_code}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>region_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="region_code"
               data-endpoint="GETapi-v1-libraries-regions--region_code-"
               value="010000000"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-provinces">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-provinces">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/provinces" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/provinces"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-provinces">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 29
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;code&quot;: &quot;012800000&quot;,
            &quot;name&quot;: &quot;Ilocos Norte&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 609588
        },
        {
            &quot;code&quot;: &quot;012900000&quot;,
            &quot;name&quot;: &quot;Ilocos Sur&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 706009
        },
        {
            &quot;code&quot;: &quot;013300000&quot;,
            &quot;name&quot;: &quot;La Union&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 822352
        },
        {
            &quot;code&quot;: &quot;015500000&quot;,
            &quot;name&quot;: &quot;Pangasinan&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 3163190
        },
        {
            &quot;code&quot;: &quot;020900000&quot;,
            &quot;name&quot;: &quot;Batanes&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 18831
        },
        {
            &quot;code&quot;: &quot;021500000&quot;,
            &quot;name&quot;: &quot;Cagayan&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 1268603
        },
        {
            &quot;code&quot;: &quot;023100000&quot;,
            &quot;name&quot;: &quot;Isabela&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 1697050
        },
        {
            &quot;code&quot;: &quot;025000000&quot;,
            &quot;name&quot;: &quot;Nueva Vizcaya&quot;,
            &quot;income_class&quot;: &quot;2nd&quot;,
            &quot;population&quot;: 497432
        },
        {
            &quot;code&quot;: &quot;025700000&quot;,
            &quot;name&quot;: &quot;Quirino&quot;,
            &quot;income_class&quot;: &quot;3rd&quot;,
            &quot;population&quot;: 203828
        },
        {
            &quot;code&quot;: &quot;030800000&quot;,
            &quot;name&quot;: &quot;Bataan&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 853373
        },
        {
            &quot;code&quot;: &quot;031400000&quot;,
            &quot;name&quot;: &quot;Bulacan&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 3708890
        },
        {
            &quot;code&quot;: &quot;034900000&quot;,
            &quot;name&quot;: &quot;Nueva Ecija&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 2310134
        },
        {
            &quot;code&quot;: &quot;035400000&quot;,
            &quot;name&quot;: &quot;Pampanga&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 2437709
        },
        {
            &quot;code&quot;: &quot;036900000&quot;,
            &quot;name&quot;: &quot;Tarlac&quot;,
            &quot;income_class&quot;: &quot;1st&quot;,
            &quot;population&quot;: 1503456
        },
        {
            &quot;code&quot;: &quot;037100000&quot;,
            &quot;name&quot;: &quot;Zambales&quot;,
            &quot;income_class&quot;: &quot;2nd&quot;,
            &quot;population&quot;: 649615
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=6&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 6,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/libraries/provinces&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 85
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-provinces" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-provinces"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-provinces"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-provinces" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-provinces"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-provinces" data-method="GET"
      data-path="api/v1/libraries/provinces"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-provinces', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-provinces"
                    onclick="tryItOut('GETapi-v1-libraries-provinces');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-provinces"
                    onclick="cancelTryOut('GETapi-v1-libraries-provinces');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-provinces" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/provinces</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-provinces--province_code-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-provinces--province_code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/provinces/012800000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/provinces/012800000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-provinces--province_code-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 28
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\PSGC\\Province] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-provinces--province_code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-provinces--province_code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-provinces--province_code-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-provinces--province_code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-provinces--province_code-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-provinces--province_code-" data-method="GET"
      data-path="api/v1/libraries/provinces/{province_code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-provinces--province_code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-provinces--province_code-"
                    onclick="tryItOut('GETapi-v1-libraries-provinces--province_code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-provinces--province_code-"
                    onclick="cancelTryOut('GETapi-v1-libraries-provinces--province_code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-provinces--province_code-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/provinces/{province_code}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>province_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="province_code"
               data-endpoint="GETapi-v1-libraries-provinces--province_code-"
               value="012800000"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-municipalities">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-municipalities">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/municipalities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/municipalities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-municipalities">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 27
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;code&quot;: &quot;012801000&quot;,
            &quot;name&quot;: &quot;Adams&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 2189
        },
        {
            &quot;code&quot;: &quot;012802000&quot;,
            &quot;name&quot;: &quot;Bacarra&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;3rd&quot;,
            &quot;population&quot;: 33496
        },
        {
            &quot;code&quot;: &quot;012803000&quot;,
            &quot;name&quot;: &quot;Badoc&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;3rd&quot;,
            &quot;population&quot;: 32530
        },
        {
            &quot;code&quot;: &quot;012804000&quot;,
            &quot;name&quot;: &quot;Bangui&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;4th&quot;,
            &quot;population&quot;: 15019
        },
        {
            &quot;code&quot;: &quot;012805000&quot;,
            &quot;name&quot;: &quot;City of Batac&quot;,
            &quot;geo_level&quot;: &quot;City&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 55484
        },
        {
            &quot;code&quot;: &quot;012806000&quot;,
            &quot;name&quot;: &quot;Burgos&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 10759
        },
        {
            &quot;code&quot;: &quot;012807000&quot;,
            &quot;name&quot;: &quot;Carasi&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 1607
        },
        {
            &quot;code&quot;: &quot;012808000&quot;,
            &quot;name&quot;: &quot;Currimao&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;4th&quot;,
            &quot;population&quot;: 12215
        },
        {
            &quot;code&quot;: &quot;012809000&quot;,
            &quot;name&quot;: &quot;Dingras&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;2nd&quot;,
            &quot;population&quot;: 40127
        },
        {
            &quot;code&quot;: &quot;012810000&quot;,
            &quot;name&quot;: &quot;Dumalneg&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;5th&quot;,
            &quot;population&quot;: 3087
        },
        {
            &quot;code&quot;: &quot;012811000&quot;,
            &quot;name&quot;: &quot;Banna&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;4th&quot;,
            &quot;population&quot;: 19297
        },
        {
            &quot;code&quot;: &quot;012812000&quot;,
            &quot;name&quot;: &quot;City of Laoag (Capital)&quot;,
            &quot;geo_level&quot;: &quot;City&quot;,
            &quot;income_class&quot;: &quot;3rd&quot;,
            &quot;population&quot;: 111651
        },
        {
            &quot;code&quot;: &quot;012813000&quot;,
            &quot;name&quot;: &quot;Marcos&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;4th&quot;,
            &quot;population&quot;: 18010
        },
        {
            &quot;code&quot;: &quot;012814000&quot;,
            &quot;name&quot;: &quot;Nueva Era&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;3rd&quot;,
            &quot;population&quot;: 11968
        },
        {
            &quot;code&quot;: &quot;012815000&quot;,
            &quot;name&quot;: &quot;Pagudpud&quot;,
            &quot;geo_level&quot;: &quot;Mun&quot;,
            &quot;income_class&quot;: &quot;4th&quot;,
            &quot;population&quot;: 25098
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=110&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 110,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=7&quot;,
                &quot;label&quot;: &quot;7&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=8&quot;,
                &quot;label&quot;: &quot;8&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=9&quot;,
                &quot;label&quot;: &quot;9&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=10&quot;,
                &quot;label&quot;: &quot;10&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;...&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=109&quot;,
                &quot;label&quot;: &quot;109&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=110&quot;,
                &quot;label&quot;: &quot;110&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/libraries/municipalities&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 1648
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-municipalities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-municipalities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-municipalities"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-municipalities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-municipalities"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-municipalities" data-method="GET"
      data-path="api/v1/libraries/municipalities"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-municipalities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-municipalities"
                    onclick="tryItOut('GETapi-v1-libraries-municipalities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-municipalities"
                    onclick="cancelTryOut('GETapi-v1-libraries-municipalities');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-municipalities" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/municipalities</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-municipalities--municipality_code-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-municipalities--municipality_code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/municipalities/012801000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/municipalities/012801000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-municipalities--municipality_code-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 26
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\PSGC\\Municipality] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-municipalities--municipality_code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-municipalities--municipality_code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-municipalities--municipality_code-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-municipalities--municipality_code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-municipalities--municipality_code-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-municipalities--municipality_code-" data-method="GET"
      data-path="api/v1/libraries/municipalities/{municipality_code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-municipalities--municipality_code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-municipalities--municipality_code-"
                    onclick="tryItOut('GETapi-v1-libraries-municipalities--municipality_code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-municipalities--municipality_code-"
                    onclick="cancelTryOut('GETapi-v1-libraries-municipalities--municipality_code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-municipalities--municipality_code-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/municipalities/{municipality_code}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>municipality_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="municipality_code"
               data-endpoint="GETapi-v1-libraries-municipalities--municipality_code-"
               value="012801000"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-barangays">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-barangays">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/barangays" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/barangays"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-barangays">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 25
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;code&quot;: &quot;012801001&quot;,
            &quot;name&quot;: &quot;Adams (Pob.)&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 2189
        },
        {
            &quot;code&quot;: &quot;012802001&quot;,
            &quot;name&quot;: &quot;Bani&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1079
        },
        {
            &quot;code&quot;: &quot;012802002&quot;,
            &quot;name&quot;: &quot;Buyon&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1669
        },
        {
            &quot;code&quot;: &quot;012802003&quot;,
            &quot;name&quot;: &quot;Cabaruan&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1418
        },
        {
            &quot;code&quot;: &quot;012802004&quot;,
            &quot;name&quot;: &quot;Cabulalaan&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 733
        },
        {
            &quot;code&quot;: &quot;012802005&quot;,
            &quot;name&quot;: &quot;Cabusligan&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1170
        },
        {
            &quot;code&quot;: &quot;012802006&quot;,
            &quot;name&quot;: &quot;Cadaratan&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1212
        },
        {
            &quot;code&quot;: &quot;012802007&quot;,
            &quot;name&quot;: &quot;Calioet-Libong&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 827
        },
        {
            &quot;code&quot;: &quot;012802008&quot;,
            &quot;name&quot;: &quot;Casilian&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1061
        },
        {
            &quot;code&quot;: &quot;012802009&quot;,
            &quot;name&quot;: &quot;Corocor&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 867
        },
        {
            &quot;code&quot;: &quot;012802011&quot;,
            &quot;name&quot;: &quot;Duripes&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1036
        },
        {
            &quot;code&quot;: &quot;012802012&quot;,
            &quot;name&quot;: &quot;Ganagan&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 701
        },
        {
            &quot;code&quot;: &quot;012802013&quot;,
            &quot;name&quot;: &quot;Libtong&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1620
        },
        {
            &quot;code&quot;: &quot;012802014&quot;,
            &quot;name&quot;: &quot;Macupit&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 647
        },
        {
            &quot;code&quot;: &quot;012802015&quot;,
            &quot;name&quot;: &quot;Nambaran&quot;,
            &quot;urban_rural&quot;: &quot;R&quot;,
            &quot;population&quot;: 1004
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2804&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 2804,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=7&quot;,
                &quot;label&quot;: &quot;7&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=8&quot;,
                &quot;label&quot;: &quot;8&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=9&quot;,
                &quot;label&quot;: &quot;9&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=10&quot;,
                &quot;label&quot;: &quot;10&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;...&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2803&quot;,
                &quot;label&quot;: &quot;2803&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2804&quot;,
                &quot;label&quot;: &quot;2804&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/libraries/barangays&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 42046
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-barangays" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-barangays"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-barangays"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-barangays" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-barangays"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-barangays" data-method="GET"
      data-path="api/v1/libraries/barangays"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-barangays', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-barangays"
                    onclick="tryItOut('GETapi-v1-libraries-barangays');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-barangays"
                    onclick="cancelTryOut('GETapi-v1-libraries-barangays');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-barangays" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/barangays</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-barangays--barangay_code-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-barangays--barangay_code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/barangays/012801001" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/barangays/012801001"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-barangays--barangay_code-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 24
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\PSGC\\Barangay] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-barangays--barangay_code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-barangays--barangay_code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-barangays--barangay_code-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-barangays--barangay_code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-barangays--barangay_code-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-barangays--barangay_code-" data-method="GET"
      data-path="api/v1/libraries/barangays/{barangay_code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-barangays--barangay_code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-barangays--barangay_code-"
                    onclick="tryItOut('GETapi-v1-libraries-barangays--barangay_code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-barangays--barangay_code-"
                    onclick="cancelTryOut('GETapi-v1-libraries-barangays--barangay_code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-barangays--barangay_code-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/barangays/{barangay_code}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>barangay_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="barangay_code"
               data-endpoint="GETapi-v1-libraries-barangays--barangay_code-"
               value="012801001"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-facilities">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-facilities">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/facilities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/facilities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-facilities">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 23
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;facility_code&quot;: &quot;DOH000000000000001&quot;,
            &quot;facility_name&quot;: &quot;PIDDIG DISTRICT HOSPITAL&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Infirmary&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 15,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;012818003&quot;,
                &quot;name&quot;: &quot;Anao (Pob.)&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 1234
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;012818000&quot;,
                &quot;name&quot;: &quot;Piddig&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 22475
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;012800000&quot;,
                &quot;name&quot;: &quot;Ilocos Norte&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 609588
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;010000000&quot;,
                &quot;name&quot;: &quot;Region I (Ilocos Region)&quot;,
                &quot;population&quot;: 5301139
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000002&quot;,
            &quot;facility_name&quot;: &quot;CEBU CITY MEDICAL CENTER&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Hospital&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: &quot;Level 1&quot;,
            &quot;bed_capacity&quot;: 225,
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;072217000&quot;,
                &quot;name&quot;: &quot;City of Cebu (Capital)&quot;,
                &quot;geo_level&quot;: &quot;City&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 964169
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;072200000&quot;,
                &quot;name&quot;: &quot;Cebu&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 3325385
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;070000000&quot;,
                &quot;name&quot;: &quot;Region VII (Central Visayas)&quot;,
                &quot;population&quot;: 8081988
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000003&quot;,
            &quot;facility_name&quot;: &quot;DON LEOVIGILDO N. DIAPO SR. MUNICIPAL HOSPITAL&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Infirmary&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 10,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;060410020&quot;,
                &quot;name&quot;: &quot;Poblacion&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 1814
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;060410000&quot;,
                &quot;name&quot;: &quot;Madalag&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;4th&quot;,
                &quot;population&quot;: 18890
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;060400000&quot;,
                &quot;name&quot;: &quot;Aklan&quot;,
                &quot;income_class&quot;: &quot;2nd&quot;,
                &quot;population&quot;: 615475
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;060000000&quot;,
                &quot;name&quot;: &quot;Region VI (Western Visayas)&quot;,
                &quot;population&quot;: 7954723
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000004&quot;,
            &quot;facility_name&quot;: &quot;LABASON DISTRICT HOSPITAL&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Infirmary&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 25,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;097205017&quot;,
                &quot;name&quot;: &quot;La Union&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 2188
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;097205000&quot;,
                &quot;name&quot;: &quot;Labason&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 43934
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;097200000&quot;,
                &quot;name&quot;: &quot;Zamboanga del Norte&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 1047455
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;090000000&quot;,
                &quot;name&quot;: &quot;Region IX (Zamboanga Peninsula)&quot;,
                &quot;population&quot;: 3875576
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000005&quot;,
            &quot;facility_name&quot;: &quot;BAGONG POOK DIST. III HEALTH CENTER&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;045624000&quot;,
                &quot;name&quot;: &quot;City of Lucena (Capital)&quot;,
                &quot;geo_level&quot;: &quot;City&quot;,
                &quot;income_class&quot;: &quot;2nd&quot;,
                &quot;population&quot;: 278924
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;045600000&quot;,
                &quot;name&quot;: &quot;Quezon&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 1950459
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;040000000&quot;,
                &quot;name&quot;: &quot;Region IV-A (CALABARZON)&quot;,
                &quot;population&quot;: 16195042
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000006&quot;,
            &quot;facility_name&quot;: &quot;IGPIT BARANGAY HEALTH STATION&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Barangay Health Station&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;112403010&quot;,
                &quot;name&quot;: &quot;Igpit&quot;,
                &quot;urban_rural&quot;: &quot;U&quot;,
                &quot;population&quot;: 3713
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;112403000&quot;,
                &quot;name&quot;: &quot;City of Digos (Capital)&quot;,
                &quot;geo_level&quot;: &quot;City&quot;,
                &quot;income_class&quot;: &quot;2nd&quot;,
                &quot;population&quot;: 188376
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;112400000&quot;,
                &quot;name&quot;: &quot;Davao del Sur&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 680481
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;110000000&quot;,
                &quot;name&quot;: &quot;Region XI (Davao Region)&quot;,
                &quot;population&quot;: 5243536
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000007&quot;,
            &quot;facility_name&quot;: &quot;LAUREN BARANGAY HEALTH STATION&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Barangay Health Station&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;015544033&quot;,
                &quot;name&quot;: &quot;Lauren&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 1194
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;015544000&quot;,
                &quot;name&quot;: &quot;Umingan&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 77074
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;015500000&quot;,
                &quot;name&quot;: &quot;Pangasinan&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 3163190
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;010000000&quot;,
                &quot;name&quot;: &quot;Region I (Ilocos Region)&quot;,
                &quot;population&quot;: 5301139
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000008&quot;,
            &quot;facility_name&quot;: &quot;LIMOT BARANGAY HEALTH STATION&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Barangay Health Station&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;112511005&quot;,
                &quot;name&quot;: &quot;Limot&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 2330
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;112511000&quot;,
                &quot;name&quot;: &quot;Tarragona&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 26996
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;112500000&quot;,
                &quot;name&quot;: &quot;Davao Oriental&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 576343
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;110000000&quot;,
                &quot;name&quot;: &quot;Region XI (Davao Region)&quot;,
                &quot;population&quot;: 5243536
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000009&quot;,
            &quot;facility_name&quot;: &quot;SAN ISIDRO BARANGAY HEALTH STATION&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Barangay Health Station&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;112404024&quot;,
                &quot;name&quot;: &quot;San Isidro&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 1777
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;112404000&quot;,
                &quot;name&quot;: &quot;Hagonoy&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;2nd&quot;,
                &quot;population&quot;: 56919
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;112400000&quot;,
                &quot;name&quot;: &quot;Davao del Sur&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 680481
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;110000000&quot;,
                &quot;name&quot;: &quot;Region XI (Davao Region)&quot;,
                &quot;population&quot;: 5243536
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000010&quot;,
            &quot;facility_name&quot;: &quot;URBIZTONDO RURAL HEALTH UNIT&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;015545018&quot;,
                &quot;name&quot;: &quot;Poblacion&quot;,
                &quot;urban_rural&quot;: &quot;U&quot;,
                &quot;population&quot;: 5234
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;015545000&quot;,
                &quot;name&quot;: &quot;Urbiztondo&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 55557
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;015500000&quot;,
                &quot;name&quot;: &quot;Pangasinan&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 3163190
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;010000000&quot;,
                &quot;name&quot;: &quot;Region I (Ilocos Region)&quot;,
                &quot;population&quot;: 5301139
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000011&quot;,
            &quot;facility_name&quot;: &quot;DILASAG RURAL HEALTH UNIT&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;037703009&quot;,
                &quot;name&quot;: &quot;Masagana (Pob.)&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 2280
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;037703000&quot;,
                &quot;name&quot;: &quot;Dilasag&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 17102
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;037700000&quot;,
                &quot;name&quot;: &quot;Aurora&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 235750
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;030000000&quot;,
                &quot;name&quot;: &quot;Region III (Central Luzon)&quot;,
                &quot;population&quot;: 12422172
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000012&quot;,
            &quot;facility_name&quot;: &quot;OUR LADY OF HOPE MEDICAL CLINIC AND HOSPITAL&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Hospital&quot;,
            &quot;ownership_classification&quot;: &quot;Private&quot;,
            &quot;ownership_sub_classification&quot;: null,
            &quot;service_capability&quot;: &quot;Level 1&quot;,
            &quot;bed_capacity&quot;: 39,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;126503022&quot;,
                &quot;name&quot;: &quot;Poblacion&quot;,
                &quot;urban_rural&quot;: &quot;U&quot;,
                &quot;population&quot;: 8078
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;126503000&quot;,
                &quot;name&quot;: &quot;Esperanza&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 74696
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;126500000&quot;,
                &quot;name&quot;: &quot;Sultan Kudarat&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 854052
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;120000000&quot;,
                &quot;name&quot;: &quot;Region XII (SOCCSKSARGEN)&quot;,
                &quot;population&quot;: 4901486
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000013&quot;,
            &quot;facility_name&quot;: &quot;MURPHY SUPER HEALTH CENTER&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;137404102&quot;,
                &quot;name&quot;: &quot;San Roque&quot;,
                &quot;urban_rural&quot;: &quot;U&quot;,
                &quot;population&quot;: 19093
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;137404000&quot;,
                &quot;name&quot;: &quot;Quezon City&quot;,
                &quot;geo_level&quot;: &quot;City&quot;,
                &quot;income_class&quot;: &quot;Special&quot;,
                &quot;population&quot;: 2960048
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;137400000&quot;,
                &quot;name&quot;: &quot;NCR, Second District (Not a Province)&quot;,
                &quot;income_class&quot;: null,
                &quot;population&quot;: 4771371
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;130000000&quot;,
                &quot;name&quot;: &quot;National Capital Region (NCR)&quot;,
                &quot;population&quot;: 13484462
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000014&quot;,
            &quot;facility_name&quot;: &quot;TOBIAS FORNIER RURAL HEALTH UNIT&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;060607037&quot;,
                &quot;name&quot;: &quot;Poblacion Norte&quot;,
                &quot;urban_rural&quot;: &quot;U&quot;,
                &quot;population&quot;: 1798
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;060607000&quot;,
                &quot;name&quot;: &quot;Tobias Fornier&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;4th&quot;,
                &quot;population&quot;: 33816
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;060600000&quot;,
                &quot;name&quot;: &quot;Antique&quot;,
                &quot;income_class&quot;: &quot;2nd&quot;,
                &quot;population&quot;: 612974
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;060000000&quot;,
                &quot;name&quot;: &quot;Region VI (Western Visayas)&quot;,
                &quot;population&quot;: 7954723
            }
        },
        {
            &quot;facility_code&quot;: &quot;DOH000000000000015&quot;,
            &quot;facility_name&quot;: &quot;CALAPE MAIN HEALTH TB DOTS AND BIRTHING CENTER&quot;,
            &quot;facility_major_type&quot;: &quot;Health Facility&quot;,
            &quot;health_facility_type&quot;: &quot;Rural Health Unit&quot;,
            &quot;ownership_classification&quot;: &quot;Government&quot;,
            &quot;ownership_sub_classification&quot;: &quot;Local Government Unit&quot;,
            &quot;service_capability&quot;: null,
            &quot;bed_capacity&quot;: 0,
            &quot;barangay&quot;: {
                &quot;code&quot;: &quot;071210013&quot;,
                &quot;name&quot;: &quot;Desamparados (Pob.)&quot;,
                &quot;urban_rural&quot;: &quot;R&quot;,
                &quot;population&quot;: 816
            },
            &quot;municipality&quot;: {
                &quot;code&quot;: &quot;071210000&quot;,
                &quot;name&quot;: &quot;Calape&quot;,
                &quot;geo_level&quot;: &quot;Mun&quot;,
                &quot;income_class&quot;: &quot;3rd&quot;,
                &quot;population&quot;: 33079
            },
            &quot;province&quot;: {
                &quot;code&quot;: &quot;071200000&quot;,
                &quot;name&quot;: &quot;Bohol&quot;,
                &quot;income_class&quot;: &quot;1st&quot;,
                &quot;population&quot;: 1394329
            },
            &quot;region&quot;: {
                &quot;code&quot;: &quot;070000000&quot;,
                &quot;name&quot;: &quot;Region VII (Central Visayas)&quot;,
                &quot;population&quot;: 8081988
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=1&quot;,
        &quot;last&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2297&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 2297,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=7&quot;,
                &quot;label&quot;: &quot;7&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=8&quot;,
                &quot;label&quot;: &quot;8&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=9&quot;,
                &quot;label&quot;: &quot;9&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=10&quot;,
                &quot;label&quot;: &quot;10&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;...&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2296&quot;,
                &quot;label&quot;: &quot;2296&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2297&quot;,
                &quot;label&quot;: &quot;2297&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://wahtermelon.test/api/v1/libraries/facilities&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 34445
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-facilities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-facilities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-facilities"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-facilities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-facilities"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-facilities" data-method="GET"
      data-path="api/v1/libraries/facilities"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-facilities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-facilities"
                    onclick="tryItOut('GETapi-v1-libraries-facilities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-facilities"
                    onclick="cancelTryOut('GETapi-v1-libraries-facilities');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-facilities" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/facilities</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-facilities--facility_facility_code-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-facilities--facility_facility_code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/facilities/DOH000000000000001" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/facilities/DOH000000000000001"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-facilities--facility_facility_code-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 22
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\PSGC\\Facility] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-facilities--facility_facility_code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-facilities--facility_facility_code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-facilities--facility_facility_code-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-facilities--facility_facility_code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-facilities--facility_facility_code-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-facilities--facility_facility_code-" data-method="GET"
      data-path="api/v1/libraries/facilities/{facility_facility_code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-facilities--facility_facility_code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-facilities--facility_facility_code-"
                    onclick="tryItOut('GETapi-v1-libraries-facilities--facility_facility_code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-facilities--facility_facility_code-"
                    onclick="cancelTryOut('GETapi-v1-libraries-facilities--facility_facility_code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-facilities--facility_facility_code-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/facilities/{facility_facility_code}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>facility_facility_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="facility_facility_code"
               data-endpoint="GETapi-v1-libraries-facilities--facility_facility_code-"
               value="DOH000000000000001"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-civil-statuses">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-civil-statuses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/civil-statuses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/civil-statuses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-civil-statuses">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 19
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;status_id&quot;: &quot;ANLD&quot;,
            &quot;status_desc&quot;: &quot;Annulled&quot;
        },
        {
            &quot;status_id&quot;: &quot;CHBTN&quot;,
            &quot;status_desc&quot;: &quot;Co-Habitation&quot;
        },
        {
            &quot;status_id&quot;: &quot;MRRD&quot;,
            &quot;status_desc&quot;: &quot;Married&quot;
        },
        {
            &quot;status_id&quot;: &quot;SNGL&quot;,
            &quot;status_desc&quot;: &quot;Single&quot;
        },
        {
            &quot;status_id&quot;: &quot;SPRTD&quot;,
            &quot;status_desc&quot;: &quot;Separated&quot;
        },
        {
            &quot;status_id&quot;: &quot;WDWD&quot;,
            &quot;status_desc&quot;: &quot;Widowed&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-civil-statuses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-civil-statuses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-civil-statuses"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-civil-statuses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-civil-statuses"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-civil-statuses" data-method="GET"
      data-path="api/v1/libraries/civil-statuses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-civil-statuses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-civil-statuses"
                    onclick="tryItOut('GETapi-v1-libraries-civil-statuses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-civil-statuses"
                    onclick="cancelTryOut('GETapi-v1-libraries-civil-statuses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-civil-statuses" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/civil-statuses</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-civil-statuses--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-civil-statuses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/civil-statuses/quis" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/civil-statuses/quis"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-civil-statuses--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 18
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibCivilStatus] quis&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-civil-statuses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-civil-statuses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-civil-statuses--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-civil-statuses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-civil-statuses--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-civil-statuses--id-" data-method="GET"
      data-path="api/v1/libraries/civil-statuses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-civil-statuses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-civil-statuses--id-"
                    onclick="tryItOut('GETapi-v1-libraries-civil-statuses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-civil-statuses--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-civil-statuses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-civil-statuses--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/civil-statuses/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-civil-statuses--id-"
               value="quis"
               data-component="url" hidden>
    <br>
<p>The ID of the civil status.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-education">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-education">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/education" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/education"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-education">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 17
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;education_id&quot;: 1,
            &quot;education_desc&quot;: &quot;Elementary Education&quot;
        },
        {
            &quot;education_id&quot;: 2,
            &quot;education_desc&quot;: &quot;High School Education&quot;
        },
        {
            &quot;education_id&quot;: 3,
            &quot;education_desc&quot;: &quot;College&quot;
        },
        {
            &quot;education_id&quot;: 4,
            &quot;education_desc&quot;: &quot;Postgraduate Program&quot;
        },
        {
            &quot;education_id&quot;: 5,
            &quot;education_desc&quot;: &quot;No Formal Education - No Schooling&quot;
        },
        {
            &quot;education_id&quot;: 6,
            &quot;education_desc&quot;: &quot;Not Applicable&quot;
        },
        {
            &quot;education_id&quot;: 7,
            &quot;education_desc&quot;: &quot;Vocational&quot;
        },
        {
            &quot;education_id&quot;: 8,
            &quot;education_desc&quot;: &quot;Others&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-education" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-education"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-education"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-education" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-education"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-education" data-method="GET"
      data-path="api/v1/libraries/education"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-education', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-education"
                    onclick="tryItOut('GETapi-v1-libraries-education');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-education"
                    onclick="cancelTryOut('GETapi-v1-libraries-education');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-education" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/education</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-education--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-education--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/education/dolorum" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/education/dolorum"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-education--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 16
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibEducation] dolorum&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-education--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-education--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-education--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-education--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-education--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-education--id-" data-method="GET"
      data-path="api/v1/libraries/education/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-education--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-education--id-"
                    onclick="tryItOut('GETapi-v1-libraries-education--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-education--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-education--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-education--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/education/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-education--id-"
               value="dolorum"
               data-component="url" hidden>
    <br>
<p>The ID of the education.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-occupation-categories">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-occupation-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/occupation-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/occupation-categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-occupation-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 15
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;category_code&quot;: &quot;AGRI&quot;,
            &quot;category_desc&quot;: &quot;Agriculture&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;AGRI001&quot;,
                    &quot;category_code&quot;: &quot;AGRI&quot;,
                    &quot;occupation_desc&quot;: &quot;Farmer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;AGRI002&quot;,
                    &quot;category_code&quot;: &quot;AGRI&quot;,
                    &quot;occupation_desc&quot;: &quot;Fisherman&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;EDUC&quot;,
            &quot;category_desc&quot;: &quot;Education&quot;,
            &quot;occupation&quot;: []
        },
        {
            &quot;category_code&quot;: &quot;FOOD&quot;,
            &quot;category_desc&quot;: &quot;Industry&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;FOOD001&quot;,
                    &quot;category_code&quot;: &quot;FOOD&quot;,
                    &quot;occupation_desc&quot;: &quot;Supervisor&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;FOOD002&quot;,
                    &quot;category_code&quot;: &quot;FOOD&quot;,
                    &quot;occupation_desc&quot;: &quot;Service Engineer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;FOOD003&quot;,
                    &quot;category_code&quot;: &quot;FOOD&quot;,
                    &quot;occupation_desc&quot;: &quot;Engineer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;FOOD004&quot;,
                    &quot;category_code&quot;: &quot;FOOD&quot;,
                    &quot;occupation_desc&quot;: &quot;Accountant&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;GOVT&quot;,
            &quot;category_desc&quot;: &quot;Government&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;GOVT&quot;,
                    &quot;category_code&quot;: &quot;GOVT&quot;,
                    &quot;occupation_desc&quot;: &quot;Govt Employee&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;GOVT001&quot;,
                    &quot;category_code&quot;: &quot;GOVT&quot;,
                    &quot;occupation_desc&quot;: &quot;Employee&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;GOVT002&quot;,
                    &quot;category_code&quot;: &quot;GOVT&quot;,
                    &quot;occupation_desc&quot;: &quot;Public School Teacher&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;HEALTH&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;HEALTH001&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Physician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH002&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Nurse&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH003&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Midwife&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH004&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Physical Therapist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH005&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Respiratory Therapist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH006&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;X-Ray Technician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH007&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Nurse Aide&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH008&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Dentist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH009&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Medical Technologist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH010&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Pharmacist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH011&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Dental Technician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH012&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Reflexologist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH013&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Pharmacist Aide&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH014&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Paramedic&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;HEALTH015&quot;,
                    &quot;category_code&quot;: &quot;HEALTH&quot;,
                    &quot;occupation_desc&quot;: &quot;Caregiver&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;MAR&quot;,
            &quot;category_desc&quot;: &quot;Maritime&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;MAR001&quot;,
                    &quot;category_code&quot;: &quot;MAR&quot;,
                    &quot;occupation_desc&quot;: &quot;Seaman&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;MFG&quot;,
            &quot;category_desc&quot;: &quot;Manufacturing&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;MFG001&quot;,
                    &quot;category_code&quot;: &quot;MFG&quot;,
                    &quot;occupation_desc&quot;: &quot;Merchandiser&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;RETL&quot;,
            &quot;category_desc&quot;: &quot;Retail&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;RETL001&quot;,
                    &quot;category_code&quot;: &quot;RETL&quot;,
                    &quot;occupation_desc&quot;: &quot;Vendor&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;RETL002&quot;,
                    &quot;category_code&quot;: &quot;RETL&quot;,
                    &quot;occupation_desc&quot;: &quot;Promo Girl&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;RETL003&quot;,
                    &quot;category_code&quot;: &quot;RETL&quot;,
                    &quot;occupation_desc&quot;: &quot;Cashier&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;SVC&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;SVC 24&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Janitor&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC001&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Employee&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC002&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Private School Teacher&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC003&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Saleslady&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC004&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Barber&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC005&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Masseur&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC006&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Factory Worker&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC007&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Painter&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC008&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Welder&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC009&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Beautician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC010&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Laundrywoman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC011&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Cook&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC012&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Guest Relations Officer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC013&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Streetsweeper&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC014&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Garbage collector&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC015&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Messenger&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC016&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Social Worker&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC017&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Laborer, skilled&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC018&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Laborer, unskilled&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC019&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Security Guard&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC020&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Service Crew&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC021&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Housemaid&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC022&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Family Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC023&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Company Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC024&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Salesman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC025&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Carpenter&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC026&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Gardener&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC027&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Actor&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC028&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Actress&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC029&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Bartender&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC030&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Policeman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC031&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Policewoman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC032&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Soldier&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC033&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Macho Dancer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC034&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Bouncer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC035&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Aircon Technician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC036&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Waiter&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC037&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Butcher&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC038&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Artist&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC039&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Technician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC040&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Dispatcher&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC041&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Electrician&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC042&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Machine Operator&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC043&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Mason&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC044&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Fireman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC045&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Domestic Helper&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC046&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Roomboy&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC047&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;OFW&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC048&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Entertainer&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC049&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Helper&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC050&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Manager&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC051&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Clerk&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC052&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Administrator&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;SVC053&quot;,
                    &quot;category_code&quot;: &quot;SVC&quot;,
                    &quot;occupation_desc&quot;: &quot;Sewer&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;TOUR&quot;,
            &quot;category_desc&quot;: &quot;Tourism&quot;,
            &quot;occupation&quot;: []
        },
        {
            &quot;category_code&quot;: &quot;TRANS&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;TRANS001&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Jeepney Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS002&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Taxi Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS003&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Bus Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS004&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Truck Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS005&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Bus Conductor&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS006&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Tricycle Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS007&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Pedicab Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS008&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Calesa Driver&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;TRANS009&quot;,
                    &quot;category_code&quot;: &quot;TRANS&quot;,
                    &quot;occupation_desc&quot;: &quot;Ambulance Driver&quot;
                }
            ]
        },
        {
            &quot;category_code&quot;: &quot;UNSP&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation&quot;: [
                {
                    &quot;occupation_code&quot;: &quot;UNSP&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Housewife&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP001&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Unspecified&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP002&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Businessman&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP003&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Retired&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP004&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Student&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP005&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;Photograper&quot;
                },
                {
                    &quot;occupation_code&quot;: &quot;UNSP006&quot;,
                    &quot;category_code&quot;: &quot;UNSP&quot;,
                    &quot;occupation_desc&quot;: &quot;None&quot;
                }
            ]
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-occupation-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-occupation-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-occupation-categories"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-occupation-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-occupation-categories"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-occupation-categories" data-method="GET"
      data-path="api/v1/libraries/occupation-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-occupation-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-occupation-categories"
                    onclick="tryItOut('GETapi-v1-libraries-occupation-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-occupation-categories"
                    onclick="cancelTryOut('GETapi-v1-libraries-occupation-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-occupation-categories" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/occupation-categories</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-occupation-categories--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-occupation-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/occupation-categories/esse" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/occupation-categories/esse"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-occupation-categories--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 14
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibOccupationCategory] esse&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-occupation-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-occupation-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-occupation-categories--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-occupation-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-occupation-categories--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-occupation-categories--id-" data-method="GET"
      data-path="api/v1/libraries/occupation-categories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-occupation-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-occupation-categories--id-"
                    onclick="tryItOut('GETapi-v1-libraries-occupation-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-occupation-categories--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-occupation-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-occupation-categories--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/occupation-categories/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-occupation-categories--id-"
               value="esse"
               data-component="url" hidden>
    <br>
<p>The ID of the occupation category.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-occupations">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-occupations">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/occupations" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/occupations"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-occupations">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 13
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;occupation_code&quot;: &quot;AGRI001&quot;,
            &quot;category_desc&quot;: &quot;Agriculture&quot;,
            &quot;occupation_desc&quot;: &quot;Farmer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;AGRI002&quot;,
            &quot;category_desc&quot;: &quot;Agriculture&quot;,
            &quot;occupation_desc&quot;: &quot;Fisherman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;FOOD001&quot;,
            &quot;category_desc&quot;: &quot;Industry&quot;,
            &quot;occupation_desc&quot;: &quot;Supervisor&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;FOOD002&quot;,
            &quot;category_desc&quot;: &quot;Industry&quot;,
            &quot;occupation_desc&quot;: &quot;Service Engineer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;FOOD003&quot;,
            &quot;category_desc&quot;: &quot;Industry&quot;,
            &quot;occupation_desc&quot;: &quot;Engineer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;FOOD004&quot;,
            &quot;category_desc&quot;: &quot;Industry&quot;,
            &quot;occupation_desc&quot;: &quot;Accountant&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;GOVT&quot;,
            &quot;category_desc&quot;: &quot;Government&quot;,
            &quot;occupation_desc&quot;: &quot;Govt Employee&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;GOVT001&quot;,
            &quot;category_desc&quot;: &quot;Government&quot;,
            &quot;occupation_desc&quot;: &quot;Employee&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;GOVT002&quot;,
            &quot;category_desc&quot;: &quot;Government&quot;,
            &quot;occupation_desc&quot;: &quot;Public School Teacher&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH001&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Physician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH002&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Nurse&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH003&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Midwife&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH004&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Physical Therapist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH005&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Respiratory Therapist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH006&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;X-Ray Technician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH007&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Nurse Aide&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH008&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Dentist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH009&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Medical Technologist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH010&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Pharmacist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH011&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Dental Technician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH012&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Reflexologist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH013&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Pharmacist Aide&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH014&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Paramedic&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;HEALTH015&quot;,
            &quot;category_desc&quot;: &quot;Health&quot;,
            &quot;occupation_desc&quot;: &quot;Caregiver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;MAR001&quot;,
            &quot;category_desc&quot;: &quot;Maritime&quot;,
            &quot;occupation_desc&quot;: &quot;Seaman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;MFG001&quot;,
            &quot;category_desc&quot;: &quot;Manufacturing&quot;,
            &quot;occupation_desc&quot;: &quot;Merchandiser&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;RETL001&quot;,
            &quot;category_desc&quot;: &quot;Retail&quot;,
            &quot;occupation_desc&quot;: &quot;Vendor&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;RETL002&quot;,
            &quot;category_desc&quot;: &quot;Retail&quot;,
            &quot;occupation_desc&quot;: &quot;Promo Girl&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;RETL003&quot;,
            &quot;category_desc&quot;: &quot;Retail&quot;,
            &quot;occupation_desc&quot;: &quot;Cashier&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC 24&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Janitor&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC001&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Employee&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC002&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Private School Teacher&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC003&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Saleslady&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC004&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Barber&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC005&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Masseur&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC006&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Factory Worker&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC007&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Painter&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC008&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Welder&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC009&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Beautician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC010&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Laundrywoman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC011&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Cook&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC012&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Guest Relations Officer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC013&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Streetsweeper&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC014&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Garbage collector&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC015&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Messenger&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC016&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Social Worker&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC017&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Laborer, skilled&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC018&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Laborer, unskilled&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC019&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Security Guard&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC020&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Service Crew&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC021&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Housemaid&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC022&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Family Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC023&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Company Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC024&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Salesman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC025&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Carpenter&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC026&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Gardener&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC027&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Actor&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC028&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Actress&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC029&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Bartender&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC030&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Policeman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC031&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Policewoman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC032&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Soldier&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC033&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Macho Dancer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC034&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Bouncer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC035&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Aircon Technician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC036&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Waiter&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC037&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Butcher&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC038&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Artist&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC039&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Technician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC040&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Dispatcher&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC041&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Electrician&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC042&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Machine Operator&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC043&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Mason&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC044&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Fireman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC045&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Domestic Helper&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC046&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Roomboy&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC047&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;OFW&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC048&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Entertainer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC049&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Helper&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC050&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Manager&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC051&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Clerk&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC052&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Administrator&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;SVC053&quot;,
            &quot;category_desc&quot;: &quot;Service&quot;,
            &quot;occupation_desc&quot;: &quot;Sewer&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS001&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Jeepney Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS002&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Taxi Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS003&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Bus Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS004&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Truck Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS005&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Bus Conductor&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS006&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Tricycle Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS007&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Pedicab Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS008&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Calesa Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;TRANS009&quot;,
            &quot;category_desc&quot;: &quot;Transport&quot;,
            &quot;occupation_desc&quot;: &quot;Ambulance Driver&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Housewife&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP001&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Unspecified&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP002&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Businessman&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP003&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Retired&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP004&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Student&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP005&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;Photograper&quot;
        },
        {
            &quot;occupation_code&quot;: &quot;UNSP006&quot;,
            &quot;category_desc&quot;: &quot;Unspecified&quot;,
            &quot;occupation_desc&quot;: &quot;None&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-occupations" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-occupations"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-occupations"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-occupations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-occupations"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-occupations" data-method="GET"
      data-path="api/v1/libraries/occupations"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-occupations', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-occupations"
                    onclick="tryItOut('GETapi-v1-libraries-occupations');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-occupations"
                    onclick="cancelTryOut('GETapi-v1-libraries-occupations');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-occupations" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/occupations</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-occupations--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-occupations--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/occupations/omnis" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/occupations/omnis"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-occupations--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 12
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibOccupation] omnis&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-occupations--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-occupations--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-occupations--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-occupations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-occupations--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-occupations--id-" data-method="GET"
      data-path="api/v1/libraries/occupations/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-occupations--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-occupations--id-"
                    onclick="tryItOut('GETapi-v1-libraries-occupations--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-occupations--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-occupations--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-occupations--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/occupations/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-occupations--id-"
               value="omnis"
               data-component="url" hidden>
    <br>
<p>The ID of the occupation.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-pwd-types">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-pwd-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/pwd-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/pwd-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-pwd-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 11
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;type_code&quot;: &quot;NA&quot;,
            &quot;type_desc&quot;: &quot;Not Applicable&quot;
        },
        {
            &quot;type_code&quot;: &quot;CID&quot;,
            &quot;type_desc&quot;: &quot;Chronic Illness&quot;
        },
        {
            &quot;type_code&quot;: &quot;CD&quot;,
            &quot;type_desc&quot;: &quot;Communication Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;LD&quot;,
            &quot;type_desc&quot;: &quot;Learning Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;MD&quot;,
            &quot;type_desc&quot;: &quot;Mental Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;OD&quot;,
            &quot;type_desc&quot;: &quot;Orthopedic Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;PD&quot;,
            &quot;type_desc&quot;: &quot;Psychosocial Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;VD&quot;,
            &quot;type_desc&quot;: &quot;Visual Disability&quot;
        },
        {
            &quot;type_code&quot;: &quot;UN&quot;,
            &quot;type_desc&quot;: &quot;Undefined&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-pwd-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-pwd-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-pwd-types"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-pwd-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-pwd-types"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-pwd-types" data-method="GET"
      data-path="api/v1/libraries/pwd-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-pwd-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-pwd-types"
                    onclick="tryItOut('GETapi-v1-libraries-pwd-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-pwd-types"
                    onclick="cancelTryOut('GETapi-v1-libraries-pwd-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-pwd-types" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/pwd-types</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-pwd-types--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-pwd-types--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/pwd-types/rerum" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/pwd-types/rerum"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-pwd-types--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 10
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibPwdType] rerum&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-pwd-types--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-pwd-types--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-pwd-types--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-pwd-types--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-pwd-types--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-pwd-types--id-" data-method="GET"
      data-path="api/v1/libraries/pwd-types/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-pwd-types--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-pwd-types--id-"
                    onclick="tryItOut('GETapi-v1-libraries-pwd-types--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-pwd-types--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-pwd-types--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-pwd-types--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/pwd-types/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-pwd-types--id-"
               value="rerum"
               data-component="url" hidden>
    <br>
<p>The ID of the pwd type.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-religions">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-religions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/religions" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/religions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-religions">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 9
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;religion_code&quot;: &quot;AGLIP&quot;,
            &quot;religion_desc&quot;: &quot;Aglipay&quot;
        },
        {
            &quot;religion_code&quot;: &quot;ALLY&quot;,
            &quot;religion_desc&quot;: &quot;Alliance of Bible Christian Communities&quot;
        },
        {
            &quot;religion_code&quot;: &quot;ANGLI&quot;,
            &quot;religion_desc&quot;: &quot;Anglican&quot;
        },
        {
            &quot;religion_code&quot;: &quot;BAPTI&quot;,
            &quot;religion_desc&quot;: &quot;Baptist&quot;
        },
        {
            &quot;religion_code&quot;: &quot;BRNAG&quot;,
            &quot;religion_desc&quot;: &quot;Born Again Christian&quot;
        },
        {
            &quot;religion_code&quot;: &quot;BUDDH&quot;,
            &quot;religion_desc&quot;: &quot;Buddhism&quot;
        },
        {
            &quot;religion_code&quot;: &quot;CATHO&quot;,
            &quot;religion_desc&quot;: &quot;Catholic&quot;
        },
        {
            &quot;religion_code&quot;: &quot;CHOG&quot;,
            &quot;religion_desc&quot;: &quot;Church of God&quot;
        },
        {
            &quot;religion_code&quot;: &quot;EVANG&quot;,
            &quot;religion_desc&quot;: &quot;Evangelical&quot;
        },
        {
            &quot;religion_code&quot;: &quot;IGNIK&quot;,
            &quot;religion_desc&quot;: &quot;Iglesia ni Cristo&quot;
        },
        {
            &quot;religion_code&quot;: &quot;JEWIT&quot;,
            &quot;religion_desc&quot;: &quot;Jehovahs Witness&quot;
        },
        {
            &quot;religion_code&quot;: &quot;LRCM&quot;,
            &quot;religion_desc&quot;: &quot;Life Renewal Christian Ministry&quot;
        },
        {
            &quot;religion_code&quot;: &quot;LUTHR&quot;,
            &quot;religion_desc&quot;: &quot;Lutheran&quot;
        },
        {
            &quot;religion_code&quot;: &quot;METOD&quot;,
            &quot;religion_desc&quot;: &quot;Methodist&quot;
        },
        {
            &quot;religion_code&quot;: &quot;MORMO&quot;,
            &quot;religion_desc&quot;: &quot;LDS-Mormons&quot;
        },
        {
            &quot;religion_code&quot;: &quot;MUSLI&quot;,
            &quot;religion_desc&quot;: &quot;Islam&quot;
        },
        {
            &quot;religion_code&quot;: &quot;PENTE&quot;,
            &quot;religion_desc&quot;: &quot;Pentecostal&quot;
        },
        {
            &quot;religion_code&quot;: &quot;PROTE&quot;,
            &quot;religion_desc&quot;: &quot;Protestant&quot;
        },
        {
            &quot;religion_code&quot;: &quot;SVDAY&quot;,
            &quot;religion_desc&quot;: &quot;Seventh Day Adventist&quot;
        },
        {
            &quot;religion_code&quot;: &quot;UCCP&quot;,
            &quot;religion_desc&quot;: &quot;UCCP&quot;
        },
        {
            &quot;religion_code&quot;: &quot;UNKNO&quot;,
            &quot;religion_desc&quot;: &quot;Unknown&quot;
        },
        {
            &quot;religion_code&quot;: &quot;WESLY&quot;,
            &quot;religion_desc&quot;: &quot;Wesleyan&quot;
        },
        {
            &quot;religion_code&quot;: &quot;XTIAN&quot;,
            &quot;religion_desc&quot;: &quot;Christian&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-religions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-religions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-religions"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-religions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-religions"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-religions" data-method="GET"
      data-path="api/v1/libraries/religions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-religions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-religions"
                    onclick="tryItOut('GETapi-v1-libraries-religions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-religions"
                    onclick="cancelTryOut('GETapi-v1-libraries-religions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-religions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/religions</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-religions--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-religions--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/religions/non" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/religions/non"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-religions--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 8
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibReligion] non&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-religions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-religions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-religions--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-religions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-religions--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-religions--id-" data-method="GET"
      data-path="api/v1/libraries/religions/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-religions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-religions--id-"
                    onclick="tryItOut('GETapi-v1-libraries-religions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-religions--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-religions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-religions--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/religions/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-religions--id-"
               value="non"
               data-component="url" hidden>
    <br>
<p>The ID of the religion.</p>
            </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-suffix-names">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-suffix-names">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/suffix-names" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/suffix-names"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-suffix-names">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 7
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;suffix_code&quot;: &quot;II&quot;,
            &quot;suffix_desc&quot;: &quot;II&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;III&quot;,
            &quot;suffix_desc&quot;: &quot;III&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;IV&quot;,
            &quot;suffix_desc&quot;: &quot;IV&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;JR&quot;,
            &quot;suffix_desc&quot;: &quot;Jr.&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;NA&quot;,
            &quot;suffix_desc&quot;: &quot;Not Applicable&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;SR&quot;,
            &quot;suffix_desc&quot;: &quot;Sr.&quot;
        },
        {
            &quot;suffix_code&quot;: &quot;V&quot;,
            &quot;suffix_desc&quot;: &quot;V&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-suffix-names" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-suffix-names"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-suffix-names"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-suffix-names" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-suffix-names"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-suffix-names" data-method="GET"
      data-path="api/v1/libraries/suffix-names"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-suffix-names', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-suffix-names"
                    onclick="tryItOut('GETapi-v1-libraries-suffix-names');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-suffix-names"
                    onclick="cancelTryOut('GETapi-v1-libraries-suffix-names');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-suffix-names" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/suffix-names</code></b>
        </p>
                    </form>

                    <h2 id="endpoints-GETapi-v1-libraries-suffix-names--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-suffix-names--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/suffix-names/enim" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/suffix-names/enim"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-suffix-names--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 6
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibSuffixName] enim&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 143,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-suffix-names--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-suffix-names--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-suffix-names--id-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-suffix-names--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-suffix-names--id-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-suffix-names--id-" data-method="GET"
      data-path="api/v1/libraries/suffix-names/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-suffix-names--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-suffix-names--id-"
                    onclick="tryItOut('GETapi-v1-libraries-suffix-names--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-suffix-names--id-"
                    onclick="cancelTryOut('GETapi-v1-libraries-suffix-names--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-suffix-names--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/suffix-names/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="id"
               data-endpoint="GETapi-v1-libraries-suffix-names--id-"
               value="enim"
               data-component="url" hidden>
    <br>
<p>The ID of the suffix name.</p>
            </p>
                    </form>

                <h1 id="libraries-for-patient-module">Libraries for Patient Module</h1>

    <p>APIs for Patient Information</p>

                        <h2 id="libraries-for-patient-module-blood-type">Blood Type</h2>
                                        <p>
                    <p>Do stuff with servers</p>
                </p>
                                        <h2 id="libraries-for-patient-module-GETapi-v1-libraries-blood-types">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-blood-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/blood-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/blood-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-blood-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 21
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;blood_type&quot;: &quot;NA&quot;
        },
        {
            &quot;blood_type&quot;: &quot;A-&quot;
        },
        {
            &quot;blood_type&quot;: &quot;A+&quot;
        },
        {
            &quot;blood_type&quot;: &quot;AB-&quot;
        },
        {
            &quot;blood_type&quot;: &quot;AB+&quot;
        },
        {
            &quot;blood_type&quot;: &quot;B-&quot;
        },
        {
            &quot;blood_type&quot;: &quot;B+&quot;
        },
        {
            &quot;blood_type&quot;: &quot;O-&quot;
        },
        {
            &quot;blood_type&quot;: &quot;O+&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-blood-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-blood-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-blood-types"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-blood-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-blood-types"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-blood-types" data-method="GET"
      data-path="api/v1/libraries/blood-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-blood-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-blood-types"
                    onclick="tryItOut('GETapi-v1-libraries-blood-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-blood-types"
                    onclick="cancelTryOut('GETapi-v1-libraries-blood-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-blood-types" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/blood-types</code></b>
        </p>
                    </form>

                    <h2 id="libraries-for-patient-module-GETapi-v1-libraries-blood-types--bloodType_blood_type-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-libraries-blood-types--bloodType_blood_type-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://wahtermelon.test/api/v1/libraries/blood-types/A-" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://wahtermelon.test/api/v1/libraries/blood-types/A-"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-libraries-blood-types--bloodType_blood_type-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 20
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No query results for model [App\\Models\\V1\\Libraries\\LibBloodType] 1&quot;,
    &quot;exception&quot;: &quot;Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException&quot;,
    &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
    &quot;line&quot;: 380,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php&quot;,
            &quot;line&quot;: 356,
            &quot;function&quot;: &quot;prepareException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/nunomaduro/collision/src/Adapters/Laravel/ExceptionHandler.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Exceptions\\Handler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;render&quot;,
            &quot;class&quot;: &quot;NunoMaduro\\Collision\\Adapters\\Laravel\\ExceptionHandler&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 185,
            &quot;function&quot;: &quot;handleException&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;handleRequestUsingNamedLimiter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 726,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 703,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 667,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 656,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 167,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\HandleCors&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php&quot;,
            &quot;line&quot;: 39,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Middleware\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 142,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 111,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 89,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 53,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 651,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 144,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 308,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1002,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 171,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 129,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/Users/noel/Project/wahtermelon/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-libraries-blood-types--bloodType_blood_type-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-libraries-blood-types--bloodType_blood_type-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-libraries-blood-types--bloodType_blood_type-"></code></pre>
</span>
<span id="execution-error-GETapi-v1-libraries-blood-types--bloodType_blood_type-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-libraries-blood-types--bloodType_blood_type-"></code></pre>
</span>
<form id="form-GETapi-v1-libraries-blood-types--bloodType_blood_type-" data-method="GET"
      data-path="api/v1/libraries/blood-types/{bloodType_blood_type}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-libraries-blood-types--bloodType_blood_type-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-libraries-blood-types--bloodType_blood_type-"
                    onclick="tryItOut('GETapi-v1-libraries-blood-types--bloodType_blood_type-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-libraries-blood-types--bloodType_blood_type-"
                    onclick="cancelTryOut('GETapi-v1-libraries-blood-types--bloodType_blood_type-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-libraries-blood-types--bloodType_blood_type-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/libraries/blood-types/{bloodType_blood_type}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>bloodType_blood_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="bloodType_blood_type"
               data-endpoint="GETapi-v1-libraries-blood-types--bloodType_blood_type-"
               value="A-"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
