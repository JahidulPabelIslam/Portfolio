<?php
$title = "Projects";
$keywords = "";
$description = "Look at the Previous Projects of Jahidul Pabel Islam, a Web and Software Developer in Bognor Regis, West Sussex Down by the South Coast of England has done before.";
$description2 = "Look at My Skills in Action in My Previous Projects.";
include '../inc/header.php';
?>

                <div id="expandedImageDivContainer">
                    <img class="slideShowNav" src="/images/previous.svg"
                         alt="Click to View Previous Image" id="expandedImagePrevious">

                    <div class="expandedImageDiv">
                        <img src="/images/blank.svg" id="expandedImage" class="expandedImage">
                    </div>
                    
                    <div class="expandedImageDiv">
                        <img src="/images/blank.svg" id="expandedImage2" class="expandedImage">
                    </div>

                    <img class="slideShowNav" id="expandedImageNext" src="/images/next.svg" alt="Click to View Next Image">
                    <button id="expandedImageClose" type="button" class="btn btn-danger">X</button>

                    <div id="slideShowNums">
                        <p id="slideShowNum"></p>
                        <p>/</p>
                        <p id="slideShowTotal"></p>
                    </div>

                    <div id="slideShowBullets" class="slideShowBullets"></div>

                </div>

                <p class="article">These are some the pieces of work I have completed during my time.</p>

                <div class="article">
                    <form id="search">
                        <div class="input-group">
                            <label id="searchLabel" for="search">Search for projects.</label>
                            <input type="text" class="form-control" placeholder="Search for projects..." id="searchInput">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="errors"></div>
                <div id="projects"></div>
                <div class="article" id="pagination"></div>

                <div class="article action">
                    <div>
                        <a class="btn btn-info" href="/contact/">Get in Touch</a>
                    </div>

                    <div>
                        <a class="btn btn-success" href="/about/">Learn About Me</a>
                    </div>
                </div>

                <!-- The Scripts needed for the page -->

                <!-- Script to expand page -->
                <script src="/lib/expandImage.js"></script>

                <script src="/lib/slideShow.js"></script>

                <!-- the script needed for any helper functions -->
                <script src="/lib/helperFunctions.js"></script>

                 <!-- the script needed for XHR -->
                <script src="/lib/xhr.js"></script>

                <!-- the script for the page -->
                <script src="/lib/projects.js"></script>

<?php
include '../inc/footer.html';
?>