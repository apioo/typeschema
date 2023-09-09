
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Developer</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Developer</h1>
  <p>This chapter provides some guidelines for developers how to build a TypeSchema code generator.</p>
  <ul>
    <li>TypeSchema is designed so that a processor can create an in-memory object representation of a schema. Every
      schema can be exactly assigned to a specific type. A processor should create a fitting class for each type and a
      factory which creates the fitting type depending on the used keywords.</li>
    <li>There is one key where all reusable types are located. For plain TypeSchema documents this is
      <code>/definitions</code> for <a href="https://github.com/OAI/OpenAPI-Specification">OpenAPI</a>, <a href="https://github.com/asyncapi/asyncapi">AsyncAPI</a>
      and <a href="https://github.com/open-rpc/spec">OpenRPC</a> documents it is <code>/components/schemas</code>. A processor
      should have an option to set the location of the <code>definitions</code> location. There is also no need for a
      JSON Pointer implementation since we only resolve local schemas.</li>
    <li>There are no nested objects instead every object must be defined under the <code>definitions</code> location.
      Object types can then reference these types. This is required since a processor needs a unique name for each
      object type, which is the definition key of the type (i.e. which is used as class name).</li>
    <li>To parse a TypeSchema we transform at the first step only the JSON into fitting objects representing the types.
      It is important that we _do not_ resolve references at the parsing step. This step is always executed when
      processing a schema.
    </li>
  </ul>

  <hr>
  <h3 id="overview">Overview</h3>

  <p>The following TypeSchema shows most keywords with a concrete reference to the specification, which should give you
  a first overview of the available keywords.</p>

  <pre><code class="json">{
  "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Import">$import</a>": {
    "my_ns": "file:///generic.json"
  },
  "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Definitions">definitions</a>": {
    "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StructType">Human</a>": {
      "type": "object",
      "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Properties">properties</a>": {
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StringType">firstName</a>": {
          "type": "string"
        },
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StringType">lastName</a>": {
          "type": "string"
        },
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#NumberType">age</a>": {
          "type": "integer"
        }
      }
    },
    "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StructType">Student</a>": {
      "$extends": "Human",
      "type": "object",
      "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Properties">properties</a>": {
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#NumberType">matricleNumber</a>": {
          "type": "integer"
        }
      }
    },
    "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#ReferenceType">StudentMap</a>": {
      "$ref": "Map",
      "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#TemplateProperties">$template</a>": {
        "T": "Student"
      }
    },
    "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StructType">Map</a>": {
      "type": "object",
      "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Properties">properties</a>": {
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#NumberType">totalResults</a>": {
          "type": "integer"
        },
        "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#ArrayType">entries</a>": {
          "type": "array",
          "items": {
            "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#GenericType">$generic</a>": "T"
          }
        }
      }
    }
  },
  "<a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#Root">$ref</a>": "StudentMap"
}</code></pre>

  <hr>
  <h3 id="parse-type">Parse type</h3>
  <p>The following algorithm shows how to create an object in-memory representation of a type. It assumes that you
  pass the raw JSON decoded object into this function and it returns a concrete type.</p>

  <p><code>function parseType(object json): Type</code></p>
  <ul>
    <li><code>Type type</code> = <code><a href="#type-detection">newType</a>(json)</code></li>
    <li>If <code>type</code> is an instance of <code>StructType</code>
      <ul>
        <li><code>Map&lt;string, Type&gt; properties</code> = Create a new empty map</li>
        <li>For each <code>key</code> : <code>property</code> in <code>json.properties</code>
          <ul>
            <li><code>properties[key]</code> = <code><a href="#parse-type">parseType</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>properties</code> to <code>type</code></li>
        <li>Parse the remaining <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StructType">struct</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>MapType</code>
      <ul>
        <li><code>Type additionalProperties</code> = <code><a href="#parse-type">parseType</a>(json.additionalProperties)</code></li>
        <li>Set <code>additionalProperties</code> to <code>type</code></li>
        <li>Parse the remaining <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#MapType">map</a> type properties from <code>json</code> and set them to the type</li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>ArrayType</code>
      <ul>
        <li><code>Type items</code> = <code><a href="#parse-type">parseType</a>(json.items)</code></li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the remaining <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#ArrayType">array</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>BooleanType</code>
      <ul>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>NumberType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#NumberType">number</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>StringType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#StringType">string</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>AnyType</code>
      <ul>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>GenericType</code>
      <ul>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>UnionType</code>
      <ul>
        <li><code>Array&lt;Type&gt; items</code> = Create an empty array</li>
        <li>For each <code>property</code> in <code>json.oneOf</code>
          <ul>
            <li><code>items[]</code> = <code><a href="#parse-type">parseType</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the remaining <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#UnionType">union</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>IntersectionType</code>
      <ul>
        <li><code>Array&lt;Type&gt; items</code> = Create an empty array</li>
        <li>For each <code>property</code> in <code>json.oneOf</code>
          <ul>
            <li><code>items[]</code> = <code><a href="#parse-type">parseType</a>(property)</code></li>
          </ul>
        </li>
        <li>Set <code>items</code> to <code>type</code></li>
        <li>Parse the remaining <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#IntersectionType">intersection</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else If <code>type</code> is an instance of <code>ReferenceType</code>
      <ul>
        <li>Parse the <a href="<?php echo $router->getAbsolutePath([App\Controller\Specification::class, 'show']); ?>#ReferenceType">reference</a> type properties from <code>json</code> and set them to <code>type</code></li>
        <li><code>return type</code></li>
      </ul>
    </li>
    <li>Else
      <ul>
        <li>Throw an exception that we could not resolve the type</li>
      </ul>
    </li>
  </ul>

  <hr>
  <h3 id="type-detection">Type detection</h3>
  <p>The following algorithm shows how to detect the correct type from a decoded JSON value.</p>

  <p><code>function newType(object json): Type|null</code></p>
  <ul>
    <li>If <code>json.type</code> is available
      <ul>
        <li>If <code>json.type</code> is equal to <code>object</code>
          <ul>
            <li>If <code>json.properties</code> is available
              <ul>
                <li><code>return new StructType</code></li>
              </ul>
            </li>
            <li>Else If <code>json.additionalProperties</code> is available
              <ul>
                <li><code>return new MapType</code></li>
              </ul>
            </li>
          </ul>
        </li>
        <li>Else If <code>json.type</code> is equal to <code>array</code>
          <ul>
            <li><code>return new ArrayType</code></li>
          </ul>
        </li>
        <li>Else If <code>json.type</code> is equal to <code>boolean</code>
          <ul>
            <li><code>return new BooleanType</code></li>
          </ul>
        </li>
        <li>Else If <code>json.type</code> is equal to <code>number</code>
          <ul>
            <li><code>return new NumberType</code></li>
          </ul>
        </li>
        <li>Else If <code>json.type</code> is equal to <code>string</code>
          <ul>
            <li><code>return new StringType</code></li>
          </ul>
        </li>
        <li>Else If <code>json.type</code> is equal to <code>any</code>
          <ul>
            <li><code>return new AnyType</code></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Else If <code>json.allOf</code> is available
      <ul>
        <li><code>return new IntersectionType</code></li>
      </ul>
    </li>
    <li>Else If <code>json.oneOf</code> is available
      <ul>
        <li><code>return new UnionType</code></li>
      </ul>
    </li>
    <li>Else If <code>json.$ref</code> is available
      <ul>
        <li><code>return new ReferenceType</code></li>
      </ul>
    </li>
    <li>Else If <code>json.$generic</code> is available
      <ul>
        <li><code>return new GenericType</code></li>
      </ul>
    </li>
    <li><code>return null</code></li>
  </ul>

  <hr>
  <h3 id="reference-resolution">Reference resolution</h3>
  <p>The following algorithm shows how to resolve a reference.</p>

  <p><code>function resolveReference(ReferenceType type, Definitions definitions): Type</code></p>
  <ul>
    <li><code>string ref = type.ref</code></li>
    <li>Replace the string <code>#/definitions/</code> and <code>#/components/schemas/</code> on <code>ref</code> with an empty string</li>

    <li>If the <code>ref</code> contains not a colon <code>:</code>
      <ul>
        <li>If the <code>ref</code> is available under the <code>definitions</code>
          <ul>
            <li><code>return definitions[ref]</code></li>
          </ul>
        </li>
        <li>Else
          <ul>
            <li>Throw an exception that we could not resolve the type</li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Else
      <ul>
        <li>Split up the <code>ref</code> string based on the colon <code>:</code> into two parts</li>
        <li><code>string namespace = parts[0]</code></li>
        <li><code>string name = parts[1]</code></li>
        <li>If the namespace is available under the <code>$import</code> keyword
          <ul>
            <li>Lookup the imported schema</li>
            <li>If the resolved schema contains a type with the provided <code>name</code>
              <ul>
                <li>Return the type of the remote schema</li>
              </ul>
            </li>
            <li>Else
              <ul>
                <li>Throw an exception that the remote schema does not contain the referenced type</li>
              </ul>
            </li>
          </ul>
        </li>
        <li>Else
          <ul>
            <li>Throw an exception that we could not resolve the namespace</li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
