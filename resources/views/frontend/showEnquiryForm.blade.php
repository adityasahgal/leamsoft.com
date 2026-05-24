            <form action="{{ url('/storeEnquiry') }}" method="POST">
                @csrf
              <div class="form-group">
                <label for="email">Product Name</label>
                <input type="text" readonly class="form-control" name="pname" value="{{ $data->product_name }}" style="height: 36px;padding: 4px 10px;" required>
              </div>
               <div class="form-group">
                <label for="email">Name</label>
                <input type="text" class="form-control" name="name" style="height: 36px;padding: 4px 10px;background: whitesmoke;" required>
              </div>
               <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" style="height: 36px;padding: 4px 10px;background: whitesmoke;" required>
              </div>
                <div class="form-group">
                <label for="email">Phone</label>
                <input type="number" class="form-control" name="phone" style="height: 36px;padding: 4px 10px;background: whitesmoke;" required>
              </div>
                <div class="form-group">
                <label for="email">Your Requirement</label>
                <textarea class="form-control" style="background: whitesmoke;" name="message"></textarea>
              </div>
              <!--<div class="checkbox">-->
              <!--  <label><input type="checkbox" required> Remember me</label>-->
              <!--</div>-->
              <div class="text-center">
              <button type="submit" class="btn btn-info">Send Enquiry</button>
              </div>
            </form>