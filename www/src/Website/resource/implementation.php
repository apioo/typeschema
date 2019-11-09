
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Implementation</li>
  </ol>
</nav>

<div class="container">

  <h1>Implementation</h1>

  <p>The following page provides implementation advices how to properly process
  a TypeSchema.</p>

  <ul>
    <li>TypeSchema is designed so that a processor can create an in-memory object
    representation of a schema. Every schema can be exactly assigned to a
    specific type. A processor should create a fitting class for each type and a
    factory which creates the fitting type depending on the used keywords.</li>
    <li>There is one key where all reusable schemas are located. For plain
    TypeSchema documents this is <code>/definitions</code> for OpenAPI documents
    it is <code>/components/schemas</code>. A process should have an option
    to set the location of the definitions location. There is also no need for
    a JSON Pointer since we only resolve local schemas.</li>
    <li>There are no nested objects instead every object must be defined under
    the definitions location. Object types can then reference these schemas. This is
    required since a processor needs a unique name for each object schema, which
    is the definition key of the schema (i.e. which is used as class name).</li>
  </ul>

  <h2>Type detection</h2>

  <p>The following algorithm shows how to detect the correct type of a schema.</p>
  
  <ul>
    <li>Keyword <code>type</code> is available
      <ul>
        <li>Keyword <code>type</code> is equal to <code>object</code>
          <ul>
            <li>Keyword <code>properties</code> is available
              <ul>
                <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#MapProperties">Struct</a></b></li>
              </ul>
            </li>
            <li>Keyword <code>additionalProperties</code> is available
              <ul>
                <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#MapProperties">Map</a></b></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>Keyword <code>type</code> is equal to <code>array</code>
          <ul>
            <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#ArrayProperties">Array</a></b></li>
          </ul>
        </li>
        <li>Keyword <code>type</code> is equal to <code>boolean</code>
          <ul>
            <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#BooleanProperties">Boolean</a></b></li>
          </ul>
        </li>
        <li>Keyword <code>type</code> is equal to <code>number</code>
          <ul>
            <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#NumberProperties">Number</a></b></li>
          </ul>
        </li>
        <li>Keyword <code>type</code> is equal to <code>string</code>
          <ul>
            <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#StringProperties">String</a></b></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Keyword <code>allOf</code> is available
      <ul>
        <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#AllOfProperties">Intersection</a></b></li>
      </ul>
    </li>
    <li>Keyword <code>oneOf</code> is available
      <ul>
        <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#OneOfProperties">Union</a></b></li>
      </ul>
    </li>
    <li>Keyword <code>$ref</code> is available
      <ul>
        <li>Resulting type is <b><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#ReferenceType">Reference</a></b></li>
      </ul>
    </li>
  </ul>

  <h2>Reference resolution</h2>

  <p></p>

  <ul>
    <li>Read all available keys under the definitions location (dont resolve the schema behind the key).</li>
    <li>Go through the properties of the schema
      <ul>
        <li>If a property is of type reference
          <ul>
            <li><code>refName</code> = Value of the <code>$ref</code> key without the definitions location string*</li>
            <li>If <code>refName</code> is available at the definitions location
              <ul>
                <li>Parse the schema recursive</li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
  
  <sup>*in JsonSchema <code>$ref</code> is a JSON pointer which can resolve to arbitrary locations or even into remote files.
  In TypeSchema we can only resolve schemas under the definitions location at the local schema. To be backwards compatible we
  strip the JSON pointer in future version it is possible to directly reference the schema by the name.</sup>
  
  <h2>Intersection resolving</h2>
  <p>The following algorithm shows how to merge all sub schemas of an
  intersection type into one schema.</p>

  <ul>
    <li>Keyword <code>allOf</code> is available and all sub schemas are of type <b>Struct</b>
      <ul>
        <li><code>subSchemas</code> = Get all <code>allOf</code> sub schemas</li>
        <li><code>newType</code> = Create a new Struct type</li>
        <li>Go through each <code>subSchemas</code>
          <ul>
            <li>Assign the <code>title</code> to the <code>newType.title</code></li>
            <li>Assign the <code>description</code> to the <code>newType.description</code></li>
            <li><code>subProperties</code> = Get <code>properties</code> of the sub schema</li>
            <li>Go through each <code>subProperties</code>
              <ul>
                <li>Assign the sub property to the <code>newType.properties</code></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>Return the <code>newType</code></li>
      </ul>
    </li>
    <li>Otherwise the merge is not possible</li>
  </ul>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
