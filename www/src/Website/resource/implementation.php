
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Implementation</li>
  </ol>
</nav>

<div class="container">

  <h1>Implementation</h1>

  <p>The following page provides implementation advices how to properly build
  a TypeSchema generator.</p>

  <ul>
    <li>TypeSchema is designed so that a processor can create an in-memory object
    representation of a schema. Every schema can be exactly assigned to a
    specific type. A processor should create a fitting class for each type and a
    factory which creates the fitting type depending on the used keywords.</li>
    <li>There is one key where all reusable schemas are located. For plain
    TypeSchema documents this is <code>/definitions</code> for <a href="https://github.com/OAI/OpenAPI-Specification">OpenAPI</a>, <a href="https://github.com/asyncapi/asyncapi">AsyncAPI</a>
    and <a href="https://github.com/open-rpc/spec">OpenRPC</a> documents it is <code>/components/schemas</code>. A processor
    should have an option to set the location of the definitions location. There
    is also no need for a JSON Pointer since we only resolve local schemas.</li>
    <li>There are no nested objects instead every object must be defined under
    the definitions location. Object types can then reference these schemas. This is
    required since a processor needs a unique name for each object schema, which
    is the definition key of the schema (i.e. which is used as class name).</li>
  </ul>

  <h4 id="parse-schema">Parse schema</h4>
  <hr>
  <p>The following algorithm shows how to create an object in-memory
  representation of a type schema. The schema can then be easily turned into
  code or other representations.</p>

  <p><code>function parseSchema(object schema): Type</code></p>
  <ul>
    <li><code>Type type</code> = <code><a href="#type-detection">newType</a>(schema)</code></li>
    <li>If <code>type</code> is an instance of <code>StructType</code>
      <ul>
        <li><code>Map&lt;string, Type&gt; properties</code> = Create a new empty map</li>
        <li>For each <code>key</code> : <code>property</code> in <code>schema.properties</code>
          <ul>
            <li><code>properties[key]</code> = <code><a href="#parse-schema">parseSchema</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>properties</code> to <code>type</code></li>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#StructProperties">struct properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>MapType</code>
      <ul>
        <li><code>Type additionalProperties</code> = <code><a href="#parse-schema">parseSchema</a>(schema.additionalProperties)</code></li>
        <li>Set <code>additionalProperties</code> to <code>type</code></li>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#MapProperties">map properties</a> from <code>schema</code> and set them to the type</li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>ArrayType</code>
      <ul>
        <li><code>Type items</code> = <code><a href="#parse-schema">parseSchema</a>(schema.items)</code></li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#ArrayProperties">array properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>BooleanType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#BooleanProperties">boolean properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>NumberType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#NumberProperties">number properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>StringType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#StringProperties">string properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>UnionType</code>
      <ul>
        <li><code>Array&lt;Type&gt; items</code> = Create an empty array</li>
        <li>For each <code>property</code> in <code>schema.oneOf</code>
          <ul>
            <li><code>items[]</code> = <code><a href="#parse-schema">parseSchema</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#OneOfProperties">union properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>IntersectionType</code>
      <ul>
        <li><code>Array&lt;Type&gt; items</code> = Create an empty array</li>
        <li>For each <code>property</code> in <code>schema.oneOf</code>
          <ul>
            <li><code>items[]</code> = <code><a href="#parse-schema">parseSchema</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#AllOfProperties">intersection properties</a> from <code>schema</code> and set them to <code>type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>ReferenceType</code>
      <ul>
        <li><code>Type ref</code> = <code><a href="#reference-resolution">resolveReference</a>(schema)</code></li>
        <li><code>return ref</code></li>
      </ul>
    </li>
    <li>Else
      <ul>
        <li>throw an exception that we could not resolve the type</li>
      </ul>
    </li>
    <li><code>return type</code></li>
  </ul>

  <h4 id="type-detection">Type detection</h4>
  <hr>
  <p>The following algorithm shows how to detect the correct type of a schema.</p>

  <p><code>function newType(object schema): Type|null</code></p>
  <ul>
    <li>If <code>schema.type</code> is available
      <ul>
        <li>If <code>schema.type</code> is equal to <code>object</code>
          <ul>
            <li>If <code>schema.properties</code> is available
              <ul>
                <li><code>return new StructType</code></li>
              </ul>
            </li>
            <li>Else If <code>schema.additionalProperties</code> is available
              <ul>
                <li><code>return new MapType</code></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>Else If <code>schema.type</code> is equal to <code>array</code>
          <ul>
            <li><code>return new ArrayType</code></li>
          </ul>
        </li>
        <li>Else If <code>schema.type</code> is equal to <code>boolean</code>
          <ul>
            <li><code>return new BooleanType</code></li>
          </ul>
        </li>
        <li>Else If <code>schema.type</code> is equal to <code>number</code>
          <ul>
            <li><code>return new NumberType</code></li>
          </ul>
        </li>
        <li>Else If <code>schema.type</code> is equal to <code>string</code>
          <ul>
            <li><code>return new StringType</code></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Else If <code>schema.allOf</code> is available
      <ul>
        <li><code>return new IntersectionType</code></li>
      </ul>
    </li>
    <li>Else If <code>schema.oneOf</code> is available
      <ul>
        <li><code>return new UnionType</code></li>
      </ul>
    </li>
    <li>Else If <code>schema.$ref</code> is available
      <ul>
        <li><code>return new ReferenceType</code></li>
      </ul>
    </li>
    <li><code>return null</code></li>
  </ul>

</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
