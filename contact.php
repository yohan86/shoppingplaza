<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="page-wrapper">
        <h2 class="page-title">Contact US</h2>
        <div class="columns-wrapper contact">
            <div class="columns map-wrapper">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6666.643851576298!2d80.11167234022922!3d6.5203972171453035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3cd23d2643e8d%3A0x85cd2d3d9fb59e60!2sMatugama%2C%20Sri%20Lanka!5e0!3m2!1sen!2sae!4v1731824515404!5m2!1sen!2sae" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="columns form contact">
                <h3>Get in touch</h3>
                <ul>
                    <li>Phone: 071-XXXXX</li>
                    <li>Email: mobile@gmail.com</li>
                    <li>Address: No 18, Kaluthara Rd,Matugama</li>
                </ul>
                
                <form>
                    <div class="field-wrapper">
                        <label>Name:*</label>
                        <input type="text" name="name" value="" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Phone:</label>
                        <input type="number" name="phone" value=""  />
                    </div>
                    <div class="field-wrapper">
                        <label>Email:*</label>
                        <input type="email" name="email" value="" required />
                    </div>
                    <div class="field-wrapper">
                        <label>Description:</label>
                        <textarea  name="description"></textarea>
                    </div>
                    <div class="field-wrapper button">
                        <span class="small-text">* Required Fields</span>
                        <button type="submit">Send  a message</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div id="footer-wrapper">
        <div class="footer">
          <div id="main-menu">
            <li class="menu-item"><a>Shop</a></li>
            <li class="menu-item active"><a>Contact Us</a></li>
          </div>
            <p>No 18, Kaluthara Rd,Matugama</p>
        </div>
      </div>

  </body>