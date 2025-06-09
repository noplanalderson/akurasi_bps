    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-6 col-md-4 col-sm-12">
          <div class="card mb-4 border-custom">
            <div class="card-header pb-0">
              <h6>Manage Tags</h6>
            </div>
            <div class="card-body">
              <table id="tbl_tags" class="table table-striped table-bordered align-items-center mb-0">
                <thead>
                  <tr class="text-center">
                    <th>Tag Name</th>
                    <th>Slug</th>
                    <th>Viewers</th>
                    <th class="no-sort">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12 mt-lg-0 mt-md-2 mt-sm-2 ">
          <div class="card mb-4 border-custom">
            <div class="card-header pb-0">
              <h6>Manage Categories</h6>
            </div>
            <div class="card-body">
              <table id="tbl_categories" class="table table-striped table-bordered align-items-center mb-0">
                <thead>
                  <tr class="text-center">
                    <th>Category</th>
                    <th>Slug</th>
                    <th>Viewers</th>
                    <th>Is Portfolio?</th>
                    <th class="no-sort">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="tagModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="Tag Management" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 id="tagModalLabel" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
              
              <div id="general_alert"></div>

              <?= form_open('blackhole/tag/save', 'id="tagForm" method="post"');?>
              
              <input type="hidden" id="tag_id" name="id" value="">
              <small id="error_tag_id" class="text-danger error-validation"></small>
              <input type="hidden" id="action_tag" name="action_tag" value="">
              <small id="error_action_tag" class="text-danger error-validation"></small>

              <div class="form-group">
                <div class="row">
                  <div class="col-12">
                    <label for="tag_name">Tag Name *</label>
                    <input id="tag_name" type="text" class="form-control" name="tag_name"  placeholder="Tag Name" required="required">
                    <small id="error_tag_name" class="text-danger error-validation"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
              <button id="submitTag" class="btn btn-success" type="submit" name="submit"><i class="fas fa-save"></i> Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="categoryModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="Category Management" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 id="categoryModalLabel" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
              
              <div id="general_alert"></div>

              <?= form_open('blackhole/category/save', 'id="categoryForm" method="post"');?>
              
              <input type="hidden" id="category_id" name="id" value="">
              <small id="error_category_id" class="text-danger error-validation"></small>
              <input type="hidden" id="action_category" name="action_category" value="">
              <small id="error_action_category" class="text-danger error-validation"></small>

              <div class="form-group">
                <div class="row">
                  <div class="col-12">
                    <label for="category">Category *</label>
                    <input id="category" type="text" class="form-control" name="category"  placeholder="Category" required="required">
                    <small id="error_category" class="text-danger error-validation"></small>
                  </div>
                  <div class="col-12 mt-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="portfolio" id="portfolio" value="1"> Is Portfolio?
                        </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
              <button id="submitCategory" class="btn btn-success" type="submit" name="submit"><i class="fas fa-save"></i> Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>