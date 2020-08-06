
<div class="sidebar">

    <ul class="list-unstyled components">
        <li class="active"> 
            <a href="{{route('admin.dashboard')}}"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
        </li>

        <li class="active"> 
            <a href="{{route('admin.customers')}}"><i class="fas fa-users"></i><span>Customers</span></a>
        </li>

        <li>
            <a href="#admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-shield"></i><span>Admins</span></a>
            
            <ul class="collapse list-unstyled" id="admin">
                <li>
                    <a href="#"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.admins')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#product" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-shopping-cart"></i><span>Products</a>
            <ul class="collapse list-unstyled" id="product">
                <li>
                    <a href="{{route('admin.product.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.products')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#category" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-align-left"></i><span>Categories</a>
            <ul class="collapse list-unstyled" id="category">
                <li>
                    <a href="{{route('admin.category.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.categories')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#subcategory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-align-right"></i><span>Sub-Categories</span></a>
            <ul class="collapse list-unstyled" id="subcategory">
                <li>
                    <a href="{{route('admin.subcategory.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.subcategories')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#unit" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fab fa-buromobelexperte"></i><span>Units</span></a>
            <ul class="collapse list-unstyled" id="unit">
                <li>
                    <a href="{{route('admin.unit.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.units')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#company" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="far fa-building"></i><span>Companies</span></a>
            <ul class="collapse list-unstyled" id="company">
                <li>
                    <a href="{{route('admin.company.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                </li>

                <li>
                    <a href="{{route('admin.companies')}}"><i class="fas fa-eye"></i><span>View</span></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#place" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-globe-europe"></i><span>Places</span></a>
            <ul class="collapse list-unstyled" id="place">
                <li>
                    <a href="#division" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-map-marker"></i><span>Divisions</a>
                    <ul class="collapse list-unstyled" id="division">
                        <li>
                            <a href="{{route('admin.division.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                        </li>

                        <li>
                            <a href="{{route('admin.divisions')}}"><i class="fas fa-eye"></i><span>View</span></a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#district" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-map-marker"></i><span>Districts</a>
                    <ul class="collapse list-unstyled" id="district">
                        <li>
                            <a href="{{route('admin.district.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                        </li>

                        <li>
                            <a href="{{route('admin.districts')}}"><i class="fas fa-eye"></i><span>View</span></a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#upazila" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-map-marker"></i><span>Upazillas</span></a>
                    <ul class="collapse list-unstyled" id="upazila">
                        <li>
                            <a href="{{route('admin.upazilla.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                        </li>

                        <li>
                            <a href="{{route('admin.upazillas')}}"><i class="fas fa-eye"></i><span>View</span></a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#union" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-map-marker"></i><span>Unions</a>
                    <ul class="collapse list-unstyled" id="union">
                        <li>
                            <a href="{{route('admin.union.create')}}"><i class="fas fa-plus"></i><span>Add New</span></a>
                        </li>

                        <li>
                            <a href="{{route('admin.unions')}}"><i class="fas fa-eye"></i><span>View</span></a>
                        </li>
                    </ul>
                </li>
        
            </ul>
        </li>
    </ul>
</div>