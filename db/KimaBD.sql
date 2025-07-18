USE [master]
GO
/****** Object:  Database [Kima]    Script Date: 24/6/2025 15:34:32 ******/
CREATE DATABASE [Kima]
GO
ALTER DATABASE [Kima] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [Kima] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [Kima] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [Kima] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [Kima] SET ARITHABORT OFF 
GO
ALTER DATABASE [Kima] SET AUTO_CLOSE ON 
GO
ALTER DATABASE [Kima] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [Kima] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [Kima] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [Kima] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [Kima] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [Kima] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [Kima] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [Kima] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [Kima] SET  ENABLE_BROKER 
GO
ALTER DATABASE [Kima] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [Kima] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [Kima] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [Kima] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [Kima] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [Kima] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [Kima] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [Kima] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [Kima] SET  MULTI_USER 
GO
ALTER DATABASE [Kima] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [Kima] SET DB_CHAINING OFF 
GO
ALTER DATABASE [Kima] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [Kima] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [Kima] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [Kima] SET QUERY_STORE = OFF
GO
USE [Kima]
GO
/****** Object:  User [kima]    Script Date: 24/6/2025 15:34:32 ******/
CREATE USER [kima] FOR LOGIN [kima] WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_owner] ADD MEMBER [kima]
GO
/****** Object:  Table [dbo].[archivos]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[archivos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](255) NOT NULL,
	[ruta] [nvarchar](255) NOT NULL,
	[tamaño] [int] NOT NULL,
	[fecha_modificacion] [datetime] NULL,
	[carpeta_id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[carpetas]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[carpetas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](255) NOT NULL,
	[fecha_creacion] [datetime] NULL,
	[ruta] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Categoria]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Categoria](
	[Categoria_ID] [int] IDENTITY(1,1) NOT NULL,
	[TipoCategoria] [varchar](50) NOT NULL,
	[NombrePersonalizado] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[Categoria_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Categoria_Serv]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Categoria_Serv](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](255) NOT NULL,
	[FechaCreacion] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Categorias]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Categorias](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [varchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CategoriasRequisitos]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CategoriasRequisitos](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [varchar](100) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clientes]    Script Date: 24/6/2025 15:34:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clientes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[empresa] [nvarchar](255) NOT NULL,
	[fecha_creacion] [date] NOT NULL,
	[telefono] [nvarchar](50) NULL,
	[direccion] [nvarchar](max) NULL,
	[estado_id] [int] NULL,
	[cedula] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[comentarios_tickets]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[comentarios_tickets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TicketID] [int] NOT NULL,
	[UsuarioID] [int] NOT NULL,
	[Comentario] [text] NOT NULL,
	[Fecha] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Contactos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Contactos](
	[ID_Contactos] [int] NOT NULL,
	[Nombre] [varchar](50) NOT NULL,
	[Telefono] [int] NOT NULL,
	[Correo] [varchar](100) NOT NULL,
	[idioma_Traduccion] [varchar](100) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Contactos] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Cotizacion]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Cotizacion](
	[ID] [int] NOT NULL,
	[Cliente_ID] [int] NULL,
	[Descripcion] [varchar](500) NULL,
	[Monto] [decimal](18, 2) NOT NULL,
	[Fecha] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cotizaciones]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cotizaciones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[cliente_id] [int] NOT NULL,
	[subtotal] [decimal](10, 2) NOT NULL,
	[iva] [decimal](10, 2) NOT NULL,
	[total] [decimal](10, 2) NOT NULL,
	[fecha_creacion] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[detalle_cotizacion]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[detalle_cotizacion](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[cotizacion_id] [int] NOT NULL,
	[producto_id] [int] NOT NULL,
	[cantidad] [int] NOT NULL,
	[precio] [decimal](10, 2) NOT NULL,
	[subtotal] [decimal](10, 2) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[documentos_tickets]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[documentos_tickets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TicketID] [int] NOT NULL,
	[NombreArchivo] [varchar](255) NOT NULL,
	[RutaArchivo] [varchar](255) NOT NULL,
	[FechaSubida] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[estados_clientes]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[estados_clientes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre_estado] [varchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[EstadosTickets]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[EstadosTickets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Estado] [varchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Historial_Contactos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Historial_Contactos](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ContactoID] [int] NULL,
	[Accion] [nvarchar](255) NULL,
	[NombreAnterior] [nvarchar](255) NULL,
	[FechaAccion] [datetime] NULL,
	[Usuario] [nvarchar](100) NULL,
	[Mensaje] [nvarchar](max) NULL,
	[notificaciones_check] [bit] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Historial_TiposProductos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Historial_TiposProductos](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TipoProductoID] [int] NOT NULL,
	[Accion] [varchar](20) NOT NULL,
	[NombreAnterior] [nvarchar](255) NULL,
	[CostoAnterior] [decimal](18, 2) NULL,
	[DescripcionAnterior] [nvarchar](max) NULL,
	[CategoriaAnterior] [int] NULL,
	[FechaAccion] [datetime] NULL,
	[Usuario] [nvarchar](100) NULL,
	[Mensaje] [nvarchar](255) NULL,
	[notificaciones_check] [tinyint] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Lista]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Lista](
	[Cedula] [int] NOT NULL,
	[Cliente_ID] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Cedula] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lista_contactos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lista_contactos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[email] [nvarchar](100) NOT NULL,
	[empresa] [nvarchar](100) NULL,
	[fecha_creacion] [datetime] NULL,
	[telefono] [nvarchar](50) NULL,
	[direccion] [nvarchar](255) NULL,
	[estado_id] [int] NOT NULL,
	[cedula] [nvarchar](50) NULL,
	[servicio] [nvarchar](100) NULL,
	[especialidad] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Notas]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Notas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[titulo] [varchar](255) NOT NULL,
	[descripcion] [text] NOT NULL,
	[fecha] [datetime] NULL,
	[usuario_id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Requisitos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Requisitos](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Descripcion] [varchar](255) NOT NULL,
	[CategoriaID] [int] NOT NULL,
	[PrioridadID] [int] NOT NULL,
	[Fecha] [date] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tarifario]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tarifario](
	[NombreServicio] [varchar](50) NOT NULL,
	[NumeroTicket] [int] NOT NULL,
	[FechaCreacion] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[NombreServicio] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tickets]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tickets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TipoProductoID] [int] NOT NULL,
	[ResponsableID] [int] NOT NULL,
	[ClienteID] [int] NOT NULL,
	[EstadoID] [int] NOT NULL,
	[FechaCreacion] [date] NOT NULL,
	[Descripcion] [text] NULL,
	[Documento] [nvarchar](255) NULL,
	[CreadoEn] [datetime] NULL,
	[ActualizadoEn] [datetime] NULL,
	[FechaFin] [datetime] NULL,
	[CategoriaID] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TiposProductos]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TiposProductos](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [varchar](100) NOT NULL,
	[Costo] [decimal](10, 2) NOT NULL,
	[FechaCreacion] [datetime] NOT NULL,
	[Descripcion] [varchar](255) NULL,
	[id_categoria_serv] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Usuarios]    Script Date: 24/6/2025 15:34:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Usuarios](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [varchar](50) NOT NULL,
	[Email] [varchar](100) NOT NULL,
	[Contraseña] [varchar](255) NOT NULL,
	[Rol] [nvarchar](15) NOT NULL,
	[estado_id] [int] NULL,
	[ImagenPerfil] [varchar](255) NULL,
	[darkmode] [bit] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[Categoria_Serv] ON 

INSERT [dbo].[Categoria_Serv] ([ID], [Nombre], [FechaCreacion]) VALUES (1, N'Software', CAST(N'2025-04-01T07:37:19.733' AS DateTime))
INSERT [dbo].[Categoria_Serv] ([ID], [Nombre], [FechaCreacion]) VALUES (2, N'Hardware', CAST(N'2025-04-01T07:37:19.733' AS DateTime))
INSERT [dbo].[Categoria_Serv] ([ID], [Nombre], [FechaCreacion]) VALUES (3, N'Servicios', CAST(N'2025-04-01T07:37:19.733' AS DateTime))
INSERT [dbo].[Categoria_Serv] ([ID], [Nombre], [FechaCreacion]) VALUES (4, N'Mantenimiento', CAST(N'2025-04-01T07:37:19.733' AS DateTime))
INSERT [dbo].[Categoria_Serv] ([ID], [Nombre], [FechaCreacion]) VALUES (5, N'Test Categoria', CAST(N'2025-04-13T15:05:48.237' AS DateTime))
SET IDENTITY_INSERT [dbo].[Categoria_Serv] OFF
SET IDENTITY_INSERT [dbo].[Categorias] ON 

INSERT [dbo].[Categorias] ([ID], [Nombre]) VALUES (1, N'Alta (Urgente)')
INSERT [dbo].[Categorias] ([ID], [Nombre]) VALUES (2, N'Media (Internedio)')
INSERT [dbo].[Categorias] ([ID], [Nombre]) VALUES (3, N'Baja')
SET IDENTITY_INSERT [dbo].[Categorias] OFF
SET IDENTITY_INSERT [dbo].[CategoriasRequisitos] ON 

INSERT [dbo].[CategoriasRequisitos] ([ID], [Nombre]) VALUES (1, N'Funcional')
INSERT [dbo].[CategoriasRequisitos] ([ID], [Nombre]) VALUES (2, N'No Funcional')
INSERT [dbo].[CategoriasRequisitos] ([ID], [Nombre]) VALUES (3, N'Requerimiento Legal')
INSERT [dbo].[CategoriasRequisitos] ([ID], [Nombre]) VALUES (4, N'Genereal')
SET IDENTITY_INSERT [dbo].[CategoriasRequisitos] OFF
SET IDENTITY_INSERT [dbo].[clientes] ON 

INSERT [dbo].[clientes] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula]) VALUES (4, N'Luis Pérez', N'luis.perez@email.com', N'Innovate Solutions', CAST(N'2025-02-18' AS Date), N'8666-4321', N'Boulevard Las Américas, Alajuela', 1, NULL)
INSERT [dbo].[clientes] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula]) VALUES (5, N'Juan González', N'ana.gonzalez@email.com', N'MarketingPro', CAST(N'2025-02-18' AS Date), N'8888888', N'Residencial Los Lagos, Cartago', 1, N'504250864')
INSERT [dbo].[clientes] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula]) VALUES (17, N'Juan Hernandez', N'kmanuel_120@hotmail.com', N'KMSOFT', CAST(N'2025-03-09' AS Date), N'89565936', N'Cañas Guanacaste, test 1', 1, N'908710876')
SET IDENTITY_INSERT [dbo].[clientes] OFF
SET IDENTITY_INSERT [dbo].[comentarios_tickets] ON 

INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (1, 204, 1, N'Comentario test 1', CAST(N'2025-04-01T02:32:41.843' AS DateTime))
INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (2, 204, 1, N'Comentario test 2', CAST(N'2025-04-01T02:32:52.540' AS DateTime))
INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (3, 204, 1, N'Test 3', CAST(N'2025-04-01T02:34:51.537' AS DateTime))
INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (10, 2220, 1, N'Ticket en proceso.', CAST(N'2025-04-09T00:28:19.357' AS DateTime))
INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (11, 1222, 1, N'Ticket cerrado.', CAST(N'2025-04-09T00:34:26.933' AS DateTime))
INSERT [dbo].[comentarios_tickets] ([ID], [TicketID], [UsuarioID], [Comentario], [Fecha]) VALUES (1010, 3220, 1, N'test de comentarios', CAST(N'2025-06-24T15:18:34.747' AS DateTime))
SET IDENTITY_INSERT [dbo].[comentarios_tickets] OFF
SET IDENTITY_INSERT [dbo].[cotizaciones] ON 

INSERT [dbo].[cotizaciones] ([id], [cliente_id], [subtotal], [iva], [total], [fecha_creacion]) VALUES (2, 17, CAST(791299.00 AS Decimal(10, 2)), CAST(102868.87 AS Decimal(10, 2)), CAST(894167.87 AS Decimal(10, 2)), CAST(N'2025-03-11T03:00:24.607' AS DateTime))
INSERT [dbo].[cotizaciones] ([id], [cliente_id], [subtotal], [iva], [total], [fecha_creacion]) VALUES (3, 17, CAST(789999.00 AS Decimal(10, 2)), CAST(102699.87 AS Decimal(10, 2)), CAST(892698.87 AS Decimal(10, 2)), CAST(N'2025-03-26T20:49:42.893' AS DateTime))
INSERT [dbo].[cotizaciones] ([id], [cliente_id], [subtotal], [iva], [total], [fecha_creacion]) VALUES (4, 4, CAST(660000.00 AS Decimal(10, 2)), CAST(85800.00 AS Decimal(10, 2)), CAST(745800.00 AS Decimal(10, 2)), CAST(N'2025-03-26T20:50:27.510' AS DateTime))
SET IDENTITY_INSERT [dbo].[cotizaciones] OFF
SET IDENTITY_INSERT [dbo].[detalle_cotizacion] ON 

INSERT [dbo].[detalle_cotizacion] ([id], [cotizacion_id], [producto_id], [cantidad], [precio], [subtotal]) VALUES (4, 2, 3, 1, CAST(1200.00 AS Decimal(10, 2)), CAST(1200.00 AS Decimal(10, 2)))
INSERT [dbo].[detalle_cotizacion] ([id], [cotizacion_id], [producto_id], [cantidad], [precio], [subtotal]) VALUES (5, 2, 4, 1, CAST(100.00 AS Decimal(10, 2)), CAST(100.00 AS Decimal(10, 2)))
INSERT [dbo].[detalle_cotizacion] ([id], [cotizacion_id], [producto_id], [cantidad], [precio], [subtotal]) VALUES (6, 2, 1, 1, CAST(789999.00 AS Decimal(10, 2)), CAST(789999.00 AS Decimal(10, 2)))
INSERT [dbo].[detalle_cotizacion] ([id], [cotizacion_id], [producto_id], [cantidad], [precio], [subtotal]) VALUES (13, 4, 2, 22, CAST(30000.00 AS Decimal(10, 2)), CAST(660000.00 AS Decimal(10, 2)))
INSERT [dbo].[detalle_cotizacion] ([id], [cotizacion_id], [producto_id], [cantidad], [precio], [subtotal]) VALUES (16, 3, 1, 1, CAST(789999.00 AS Decimal(10, 2)), CAST(789999.00 AS Decimal(10, 2)))
SET IDENTITY_INSERT [dbo].[detalle_cotizacion] OFF
SET IDENTITY_INSERT [dbo].[documentos_tickets] ON 

INSERT [dbo].[documentos_tickets] ([ID], [TicketID], [NombreArchivo], [RutaArchivo], [FechaSubida]) VALUES (1, 1219, N'1743841721_Comparison_FairHarbor_vs_WeTravel_EN.pdf', N'/uploads/1743841721_Comparison_FairHarbor_vs_WeTravel_EN.pdf', CAST(N'2025-04-05T02:28:41.820' AS DateTime))
INSERT [dbo].[documentos_tickets] ([ID], [TicketID], [NombreArchivo], [RutaArchivo], [FechaSubida]) VALUES (2, 1219, N'1743841721_Comparativa_FairHarbor_vs_WeTravel.pdf', N'/uploads/1743841721_Comparativa_FairHarbor_vs_WeTravel.pdf', CAST(N'2025-04-05T02:28:41.823' AS DateTime))
INSERT [dbo].[documentos_tickets] ([ID], [TicketID], [NombreArchivo], [RutaArchivo], [FechaSubida]) VALUES (3, 1219, N'1743841721_Website revisions.pdf', N'/uploads/1743841721_Website revisions.pdf', CAST(N'2025-04-05T02:28:41.823' AS DateTime))
INSERT [dbo].[documentos_tickets] ([ID], [TicketID], [NombreArchivo], [RutaArchivo], [FechaSubida]) VALUES (4, 1222, N'ticket-1222_1743847530_Comparison_FairHarbor_vs_WeTravel_EN.pdf', N'/uploads/ticket-1222_1743847530_Comparison_FairHarbor_vs_WeTravel_EN.pdf', CAST(N'2025-04-05T04:05:30.380' AS DateTime))
SET IDENTITY_INSERT [dbo].[documentos_tickets] OFF
SET IDENTITY_INSERT [dbo].[estados_clientes] ON 

INSERT [dbo].[estados_clientes] ([id], [nombre_estado]) VALUES (1, N'Activo')
INSERT [dbo].[estados_clientes] ([id], [nombre_estado]) VALUES (2, N'Inactivo')
SET IDENTITY_INSERT [dbo].[estados_clientes] OFF
SET IDENTITY_INSERT [dbo].[EstadosTickets] ON 

INSERT [dbo].[EstadosTickets] ([ID], [Estado]) VALUES (3, N'Closed')
INSERT [dbo].[EstadosTickets] ([ID], [Estado]) VALUES (2, N'In Progress')
INSERT [dbo].[EstadosTickets] ([ID], [Estado]) VALUES (5, N'Open')
INSERT [dbo].[EstadosTickets] ([ID], [Estado]) VALUES (4, N'Pending')
SET IDENTITY_INSERT [dbo].[EstadosTickets] OFF
SET IDENTITY_INSERT [dbo].[Historial_Contactos] ON 

INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1, 2002, N'INSERTAR', N'Manuel Orozco', CAST(N'2025-04-18T21:05:26.657' AS DateTime), N'Sistema', N'Se agregó un contacto con el nombre de Manuel Orozco, creado por Sistema', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (2, 2003, N'INSERTAR', N'Eneida', CAST(N'2025-04-18T21:07:40.850' AS DateTime), N'Sistema', N'Se agregó un contacto con el nombre de Eneida, creado por Sistema', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (3, 2004, N'INSERTAR', N'Victor Orozco', CAST(N'2025-04-18T21:15:21.983' AS DateTime), N'Marc Gómez', N'Se agregó un contacto con el nombre de Victor Orozco, creado por Marc Gómez', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (4, 2, N'ACTUALIZACIÓN', N'Kevin Manuel', CAST(N'2025-04-18T22:28:52.490' AS DateTime), NULL, N'Se actualizó el contacto ''Kevin Manuel'', modificado por ', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (5, 2, N'ACTUALIZACIÓN', N'Kevin Manuel', CAST(N'2025-04-18T22:29:34.580' AS DateTime), NULL, N'Se actualizó el contacto ''Kevin Manuel'', modificado por ', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (6, 2, N'ACTUALIZACIÓN', N'Kevin Manuel', CAST(N'2025-04-18T22:35:05.820' AS DateTime), N'Marc Gómez', N'Se actualizó el contacto ''Kevin Manuel'', modificado por Marc Gómez', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (7, 2, N'ACTUALIZACIÓN', N'Kevin Manuel', CAST(N'2025-04-18T22:35:19.710' AS DateTime), N'Marc Gómez', N'Se actualizó el contacto ''Kevin Manuel'', modificado por Marc Gómez', 1)
INSERT [dbo].[Historial_Contactos] ([ID], [ContactoID], [Accion], [NombreAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1004, 2004, N'ACTUALIZACIÓN', N'Victor Orozco test', CAST(N'2025-06-24T15:16:49.200' AS DateTime), N'Marc Gómez', N'Se actualizó el contacto ''Victor Orozco test'', modificado por Marc Gómez', 0)
SET IDENTITY_INSERT [dbo].[Historial_Contactos] OFF
SET IDENTITY_INSERT [dbo].[Historial_TiposProductos] ON 

INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1, 17, N'ACTUALIZAR', N'Mantenimiento de equipos', CAST(500.00 AS Decimal(18, 2)), N'Limpiexa y actualización de equipos', 4, CAST(N'2025-04-01T10:45:49.360' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (2, 1, N'ACTUALIZAR', N'Desarrollo de Software', CAST(789999.00 AS Decimal(18, 2)), N'Desarrollo de Software', 1, CAST(N'2025-04-01T10:49:22.217' AS DateTime), N'Desconocido', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (3, 4, N'ACTUALIZAR', N'Mantenimiento', CAST(100.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-01T11:02:09.413' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (4, 1, N'ACTUALIZAR', N'Desarrollo de Software', CAST(400.00 AS Decimal(18, 2)), N'Desarrollo de Software', 1, CAST(N'2025-04-01T11:04:33.383' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (5, 18, N'INSERTAR', NULL, NULL, NULL, NULL, CAST(N'2025-04-01T11:05:07.947' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (6, 18, N'ELIMINAR', N'Servicio Test 2', CAST(500.00 AS Decimal(18, 2)), N'tst', 3, CAST(N'2025-04-01T11:05:28.203' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (7, 19, N'INSERTAR', NULL, NULL, NULL, NULL, CAST(N'2025-04-09T03:33:13.563' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (8, 2, N'ACTUALIZAR', N'Hardware', CAST(30000.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-09T03:34:07.643' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (9, 19, N'ELIMINAR', N'Aplicaciones Moviles', CAST(3000.00 AS Decimal(18, 2)), N'Servicio de applpicaciones moviles', 1, CAST(N'2025-04-09T05:08:48.107' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1007, 1019, N'INSERTAR', NULL, NULL, NULL, NULL, CAST(N'2025-04-13T14:45:25.857' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1008, 1019, N'ELIMINAR', N'Servicio Test 3', CAST(500.00 AS Decimal(18, 2)), N'hola', 2, CAST(N'2025-04-13T14:45:37.897' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1009, 1020, N'INSERTAR', NULL, NULL, NULL, NULL, CAST(N'2025-04-13T14:45:52.870' AS DateTime), NULL, NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1010, 1020, N'ELIMINAR', N'Servicio Test 3', CAST(500.00 AS Decimal(18, 2)), N'tewst hola', 2, CAST(N'2025-04-13T14:46:00.480' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1011, 17, N'ACTUALIZAR', N'Mantenimiento de equipos', CAST(6000.00 AS Decimal(18, 2)), N'Limpiexa y actualización de equipos', 4, CAST(N'2025-04-13T15:07:11.100' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1012, 17, N'ACTUALIZAR', N'Mantenimiento de equipos', CAST(6000.00 AS Decimal(18, 2)), N'Limpiexa y actualización de equipos', 5, CAST(N'2025-04-13T15:25:46.670' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1013, 4, N'CAMBIO_PRECIO', N'Mantenimiento', CAST(3000.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T15:26:11.657' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1014, 4, N'ACTUALIZAR', N'Mantenimiento', CAST(3000.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T15:26:11.657' AS DateTime), N'Marc Gómez', NULL, NULL)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1015, 1, N'CAMBIO_PRECIO', N'Desarrollo de Software', CAST(800.00 AS Decimal(18, 2)), N'Desarrollo de Software', 1, CAST(N'2025-04-13T16:08:45.220' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡800.00 → ₡900', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1016, 1, N'ACTUALIZAR', N'Desarrollo de Software', CAST(800.00 AS Decimal(18, 2)), N'Desarrollo de Software', 1, CAST(N'2025-04-13T16:08:45.220' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1017, 2, N'CAMBIO_PRECIO', N'Hardware', CAST(500.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:18:15.190' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡500.00 → ₡700', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1018, 2, N'ACTUALIZAR', N'Hardware', CAST(500.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:18:15.190' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1019, 4, N'CAMBIO_PRECIO', N'Mantenimiento', CAST(315.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T16:20:00.080' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡315.00 → ₡312.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1020, 4, N'ACTUALIZAR', N'Mantenimiento', CAST(315.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T16:20:00.080' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1021, 2, N'CAMBIO_PRECIO', N'Hardware', CAST(700.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:20:48.507' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡700.00 → ₡740.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1022, 2, N'ACTUALIZAR', N'Hardware', CAST(700.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:20:48.507' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1023, 2, N'CAMBIO_PRECIO', N'Hardware', CAST(740.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:22:56.083' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡740.00 → ₡760.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1024, 2, N'ACTUALIZAR', N'Hardware', CAST(740.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:22:56.083' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1025, 3, N'CAMBIO_PRECIO', N'Servicios', CAST(200.00 AS Decimal(18, 2)), N'Servicios', 3, CAST(N'2025-04-13T16:23:52.580' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡200.00 → ₡210.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1026, 3, N'ACTUALIZAR', N'Servicios', CAST(200.00 AS Decimal(18, 2)), N'Servicios', 3, CAST(N'2025-04-13T16:23:52.583' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1027, 4, N'CAMBIO_PRECIO', N'Mantenimiento', CAST(312.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T16:24:27.923' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡312.00 → ₡322.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1028, 4, N'ACTUALIZAR', N'Mantenimiento', CAST(312.00 AS Decimal(18, 2)), N'Mantenimiento', 4, CAST(N'2025-04-13T16:24:27.923' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1029, 2, N'CAMBIO_PRECIO', N'Hardware', CAST(760.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:27:17.730' AS DateTime), N'Marc Gómez', N'Cambio de precio: ₡760.00 → ₡730.00', 1)
INSERT [dbo].[Historial_TiposProductos] ([ID], [TipoProductoID], [Accion], [NombreAnterior], [CostoAnterior], [DescripcionAnterior], [CategoriaAnterior], [FechaAccion], [Usuario], [Mensaje], [notificaciones_check]) VALUES (1030, 2, N'ACTUALIZAR', N'Hardware', CAST(760.00 AS Decimal(18, 2)), N'Hardware', 2, CAST(N'2025-04-13T16:27:17.730' AS DateTime), N'Marc Gómez', N'Se actualizo el servicio.', 1)
SET IDENTITY_INSERT [dbo].[Historial_TiposProductos] OFF
SET IDENTITY_INSERT [dbo].[lista_contactos] ON 

INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (2, N'Kevin Manuel', N'kmanuel_124@hotmail.es', N'KMSOFT', CAST(N'2025-04-09T03:19:19.440' AS DateTime), N'89565936', N'Tilaran, Guanacaste', 1, N'504250864', N'Desarrollador Jr', N'Software')
INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (1002, N'Juan Hernandez', N'kmanuel12222@gmail.com', N'KMSOFT', CAST(N'2025-04-18T04:46:18.837' AS DateTime), N'89542438', N'Cañas
201', 1, N'908710875', N'test 1', N'test 2')
INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (1003, N'Ana González', N'ana.gonzalez@email.com', N'KMSOFT', CAST(N'2025-04-18T05:06:37.860' AS DateTime), N'89565930', N'Guana', 1, N'9087108777', N'test serviicio', N'test especialidad')
INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (2002, N'Manuel Orozco', N'manuel@gmail.com', N'KMSOFT', CAST(N'2025-04-18T21:05:26.647' AS DateTime), N'87869002', N'Cañas, Gte', 1, N'603010020', N'Software', N'Frontend')
INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (2003, N'Eneida', N'eneida@gmail.com', N'KMSOFT', CAST(N'2025-04-18T21:07:40.847' AS DateTime), N'89551235', N'Cañas, Gte', 1, N'503010020', N'Coordinación', N'Proyect Manager')
INSERT [dbo].[lista_contactos] ([id], [nombre], [email], [empresa], [fecha_creacion], [telefono], [direccion], [estado_id], [cedula], [servicio], [especialidad]) VALUES (2004, N'Victor Orozco test', N'victor@gmail.com', N'KMSOFT', CAST(N'2025-04-18T21:15:21.980' AS DateTime), N'87052030', N'Tilaran,, Gte', 1, N'508340964', N'Desarrollo', N'Software')
SET IDENTITY_INSERT [dbo].[lista_contactos] OFF
SET IDENTITY_INSERT [dbo].[Notas] ON 

INSERT [dbo].[Notas] ([id], [titulo], [descripcion], [fecha], [usuario_id]) VALUES (1, N'Test de notas', N'Detalle de notas', CAST(N'2025-04-14T20:04:20.920' AS DateTime), NULL)
INSERT [dbo].[Notas] ([id], [titulo], [descripcion], [fecha], [usuario_id]) VALUES (2, N'Test de notas 2', N'Detalles notas 2', CAST(N'2025-04-14T20:05:35.347' AS DateTime), NULL)
INSERT [dbo].[Notas] ([id], [titulo], [descripcion], [fecha], [usuario_id]) VALUES (3, N'Test de notas', N'Descripción Notas ', CAST(N'2025-04-14T20:59:38.443' AS DateTime), 1)
INSERT [dbo].[Notas] ([id], [titulo], [descripcion], [fecha], [usuario_id]) VALUES (4, N'Test de notas editar', N'Descripción editar', CAST(N'2025-04-14T21:00:06.073' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[Notas] OFF
SET IDENTITY_INSERT [dbo].[Requisitos] ON 

INSERT [dbo].[Requisitos] ([ID], [Descripcion], [CategoriaID], [PrioridadID], [Fecha]) VALUES (1, N'Requisito 1', 1, 1, CAST(N'2024-12-08' AS Date))
INSERT [dbo].[Requisitos] ([ID], [Descripcion], [CategoriaID], [PrioridadID], [Fecha]) VALUES (2, N'Requisito 2', 2, 1, CAST(N'2024-12-07' AS Date))
INSERT [dbo].[Requisitos] ([ID], [Descripcion], [CategoriaID], [PrioridadID], [Fecha]) VALUES (3, N'Requisito 3', 3, 1, CAST(N'2024-12-06' AS Date))
INSERT [dbo].[Requisitos] ([ID], [Descripcion], [CategoriaID], [PrioridadID], [Fecha]) VALUES (1009, N'Requisito 4', 4, 1, CAST(N'2025-03-31' AS Date))
SET IDENTITY_INSERT [dbo].[Requisitos] OFF
SET IDENTITY_INSERT [dbo].[Tickets] ON 

INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (204, 3, 2, 4, 3, CAST(N'2025-03-04' AS Date), N'tesst 4456', NULL, CAST(N'2025-03-04T03:07:21.693' AS DateTime), CAST(N'2025-04-15T01:47:40.133' AS DateTime), CAST(N'2025-03-05T00:33:48.367' AS DateTime), 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1214, 1, 2, 17, 5, CAST(N'2025-04-05' AS Date), N'Deseamos recibir una cotización, de un software con los requerimientos en el documento adjunto.', NULL, CAST(N'2025-04-05T00:59:26.123' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1215, 3, 5, 5, 5, CAST(N'2025-04-05' AS Date), N'Sistema de manejo google Ads, según estandares de Marketing.', NULL, CAST(N'2025-04-05T01:11:40.420' AS DateTime), NULL, NULL, 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1216, 2, 5, 4, 5, CAST(N'2025-04-05' AS Date), N'Por favor deseamos cotización de limpieza de equipos descritos en el documento adjunto.', NULL, CAST(N'2025-04-05T01:34:32.820' AS DateTime), NULL, NULL, 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1217, 3, 2, 5, 5, CAST(N'2025-04-05' AS Date), N'Servicio de marketing completo para cliente nuevo', NULL, CAST(N'2025-04-05T01:37:11.750' AS DateTime), NULL, NULL, 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1218, 1, 2, 17, 5, CAST(N'2025-04-05' AS Date), N'desarrollo a la medida', NULL, CAST(N'2025-04-05T01:45:24.917' AS DateTime), NULL, NULL, 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1219, 1, 5, 17, 5, CAST(N'2025-04-05' AS Date), N'Urgencia, requisitos en documento asjunto', NULL, CAST(N'2025-04-05T02:28:41.817' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1220, 1, 5, 17, 5, CAST(N'2025-04-05' AS Date), N'Ticket de prueba para documentos ', NULL, CAST(N'2025-04-05T03:56:17.960' AS DateTime), NULL, NULL, 3)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1221, 4, 2, 17, 5, CAST(N'2025-04-05' AS Date), N'test ', NULL, CAST(N'2025-04-05T04:02:45.763' AS DateTime), NULL, NULL, 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (1222, 17, 1, 17, 3, CAST(N'2025-04-05' AS Date), N'Mantenimiento test', NULL, CAST(N'2025-04-05T04:05:30.373' AS DateTime), CAST(N'2025-04-09T00:34:28.203' AS DateTime), CAST(N'2025-04-09T00:34:28.000' AS DateTime), 2)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (2220, 1, 2, 17, 4, CAST(N'2025-04-09' AS Date), N'test', NULL, CAST(N'2025-04-09T00:23:29.987' AS DateTime), CAST(N'2025-04-09T00:43:38.683' AS DateTime), NULL, 1)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (3220, 1, 1, 5, 4, CAST(N'2025-04-14' AS Date), N'Desarollo de sistema Kima', NULL, CAST(N'2025-04-14T11:42:29.040' AS DateTime), CAST(N'2025-04-14T11:43:11.750' AS DateTime), NULL, 1)
INSERT [dbo].[Tickets] ([ID], [TipoProductoID], [ResponsableID], [ClienteID], [EstadoID], [FechaCreacion], [Descripcion], [Documento], [CreadoEn], [ActualizadoEn], [FechaFin], [CategoriaID]) VALUES (3221, 2, 1, 17, 5, CAST(N'2025-04-14' AS Date), N'Test de equipos nuevos', NULL, CAST(N'2025-04-14T11:42:54.293' AS DateTime), NULL, NULL, 2)
SET IDENTITY_INSERT [dbo].[Tickets] OFF
SET IDENTITY_INSERT [dbo].[TiposProductos] ON 

INSERT [dbo].[TiposProductos] ([ID], [Nombre], [Costo], [FechaCreacion], [Descripcion], [id_categoria_serv]) VALUES (1, N'Desarrollo de Software', CAST(900.00 AS Decimal(10, 2)), CAST(N'2025-02-18T11:17:31.350' AS DateTime), N'Desarrollo de Software', 1)
INSERT [dbo].[TiposProductos] ([ID], [Nombre], [Costo], [FechaCreacion], [Descripcion], [id_categoria_serv]) VALUES (2, N'Hardware', CAST(730.00 AS Decimal(10, 2)), CAST(N'2025-02-18T11:17:31.350' AS DateTime), N'Hardware', 2)
INSERT [dbo].[TiposProductos] ([ID], [Nombre], [Costo], [FechaCreacion], [Descripcion], [id_categoria_serv]) VALUES (3, N'Servicios', CAST(210.00 AS Decimal(10, 2)), CAST(N'2025-02-18T11:17:31.350' AS DateTime), N'Servicios', 3)
INSERT [dbo].[TiposProductos] ([ID], [Nombre], [Costo], [FechaCreacion], [Descripcion], [id_categoria_serv]) VALUES (4, N'Mantenimiento', CAST(322.00 AS Decimal(10, 2)), CAST(N'2025-02-18T11:17:31.350' AS DateTime), N'Mantenimiento', 4)
INSERT [dbo].[TiposProductos] ([ID], [Nombre], [Costo], [FechaCreacion], [Descripcion], [id_categoria_serv]) VALUES (17, N'Mantenimiento de equipos', CAST(6000.00 AS Decimal(10, 2)), CAST(N'2025-04-01T07:58:51.550' AS DateTime), N'Limpiexa y actualización de equipos', 4)
SET IDENTITY_INSERT [dbo].[TiposProductos] OFF
SET IDENTITY_INSERT [dbo].[Usuarios] ON 

INSERT [dbo].[Usuarios] ([ID], [Nombre], [Email], [Contraseña], [Rol], [estado_id], [ImagenPerfil], [darkmode]) VALUES (1, N'Marc Gómez', N'marc.gomez@gmail.com', N'$2y$10$3bYyT.N4luhlrw9gQbKkOOOQfwiC45jwIzkZii7UTdFd5ZaXdQz2a', N'Admin', 1, N'67f629de4f6cd_300-3.jpg', 1)
INSERT [dbo].[Usuarios] ([ID], [Nombre], [Email], [Contraseña], [Rol], [estado_id], [ImagenPerfil], [darkmode]) VALUES (2, N'Yurán Reyes', N'yuran.reyes@gmail.com', N'$2y$10$2aRUrrsCJAiMti.Zs3T19eoB.HfEkHuF9izyfh6/kwXInZsS9g3P2', N'Admin', 1, NULL, 0)
INSERT [dbo].[Usuarios] ([ID], [Nombre], [Email], [Contraseña], [Rol], [estado_id], [ImagenPerfil], [darkmode]) VALUES (5, N'Kevin Manuel', N'kevin.elizondo@kmsoftcr.com', N'$2y$10$RZ3vUJL3T3YNSZcnFADYLuVSptSaIH4j8/IQRXFPof/DQiIDqu9KK', N'Admin', 1, N'67f621856202e_logo_kima_v1.png', 0)
SET IDENTITY_INSERT [dbo].[Usuarios] OFF
SET ANSI_PADDING ON
GO
/****** Object:  Index [UQ__estados___2F8C63754C791545]    Script Date: 24/6/2025 15:34:33 ******/
ALTER TABLE [dbo].[estados_clientes] ADD UNIQUE NONCLUSTERED 
(
	[nombre_estado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UQ__EstadosT__36DF552F2BB1F915]    Script Date: 24/6/2025 15:34:33 ******/
ALTER TABLE [dbo].[EstadosTickets] ADD UNIQUE NONCLUSTERED 
(
	[Estado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UQ__TiposPro__75E3EFCF52731826]    Script Date: 24/6/2025 15:34:33 ******/
ALTER TABLE [dbo].[TiposProductos] ADD UNIQUE NONCLUSTERED 
(
	[Nombre] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UQ__Usuarios__A9D1053492B94508]    Script Date: 24/6/2025 15:34:33 ******/
ALTER TABLE [dbo].[Usuarios] ADD UNIQUE NONCLUSTERED 
(
	[Email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[archivos] ADD  DEFAULT (getdate()) FOR [fecha_modificacion]
GO
ALTER TABLE [dbo].[carpetas] ADD  DEFAULT (getdate()) FOR [fecha_creacion]
GO
ALTER TABLE [dbo].[Categoria_Serv] ADD  DEFAULT (getdate()) FOR [FechaCreacion]
GO
ALTER TABLE [dbo].[comentarios_tickets] ADD  DEFAULT (getdate()) FOR [Fecha]
GO
ALTER TABLE [dbo].[cotizaciones] ADD  DEFAULT (getdate()) FOR [fecha_creacion]
GO
ALTER TABLE [dbo].[documentos_tickets] ADD  DEFAULT (getdate()) FOR [FechaSubida]
GO
ALTER TABLE [dbo].[Historial_Contactos] ADD  DEFAULT ((0)) FOR [notificaciones_check]
GO
ALTER TABLE [dbo].[Historial_TiposProductos] ADD  DEFAULT (getdate()) FOR [FechaAccion]
GO
ALTER TABLE [dbo].[Historial_TiposProductos] ADD  DEFAULT ((0)) FOR [notificaciones_check]
GO
ALTER TABLE [dbo].[lista_contactos] ADD  DEFAULT (getdate()) FOR [fecha_creacion]
GO
ALTER TABLE [dbo].[Notas] ADD  DEFAULT (getdate()) FOR [fecha]
GO
ALTER TABLE [dbo].[Requisitos] ADD  DEFAULT (getdate()) FOR [Fecha]
GO
ALTER TABLE [dbo].[Tickets] ADD  DEFAULT (getdate()) FOR [CreadoEn]
GO
ALTER TABLE [dbo].[TiposProductos] ADD  DEFAULT ((0)) FOR [Costo]
GO
ALTER TABLE [dbo].[TiposProductos] ADD  DEFAULT (getdate()) FOR [FechaCreacion]
GO
ALTER TABLE [dbo].[Usuarios] ADD  DEFAULT ('Usr') FOR [Rol]
GO
ALTER TABLE [dbo].[Usuarios] ADD  DEFAULT ((0)) FOR [darkmode]
GO
ALTER TABLE [dbo].[archivos]  WITH CHECK ADD  CONSTRAINT [FK_Archivos_Carpetas] FOREIGN KEY([carpeta_id])
REFERENCES [dbo].[carpetas] ([id])
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[archivos] CHECK CONSTRAINT [FK_Archivos_Carpetas]
GO
ALTER TABLE [dbo].[clientes]  WITH CHECK ADD  CONSTRAINT [FK_clientes_estados] FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados_clientes] ([id])
GO
ALTER TABLE [dbo].[clientes] CHECK CONSTRAINT [FK_clientes_estados]
GO
ALTER TABLE [dbo].[comentarios_tickets]  WITH CHECK ADD FOREIGN KEY([TicketID])
REFERENCES [dbo].[Tickets] ([ID])
GO
ALTER TABLE [dbo].[comentarios_tickets]  WITH CHECK ADD FOREIGN KEY([UsuarioID])
REFERENCES [dbo].[Usuarios] ([ID])
GO
ALTER TABLE [dbo].[cotizaciones]  WITH CHECK ADD FOREIGN KEY([cliente_id])
REFERENCES [dbo].[clientes] ([id])
GO
ALTER TABLE [dbo].[detalle_cotizacion]  WITH CHECK ADD FOREIGN KEY([cotizacion_id])
REFERENCES [dbo].[cotizaciones] ([id])
GO
ALTER TABLE [dbo].[detalle_cotizacion]  WITH CHECK ADD FOREIGN KEY([producto_id])
REFERENCES [dbo].[TiposProductos] ([ID])
GO
ALTER TABLE [dbo].[documentos_tickets]  WITH CHECK ADD FOREIGN KEY([TicketID])
REFERENCES [dbo].[Tickets] ([ID])
GO
ALTER TABLE [dbo].[Historial_Contactos]  WITH CHECK ADD  CONSTRAINT [FK_Historial_ContactoID] FOREIGN KEY([ContactoID])
REFERENCES [dbo].[lista_contactos] ([id])
ON UPDATE CASCADE
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[Historial_Contactos] CHECK CONSTRAINT [FK_Historial_ContactoID]
GO
ALTER TABLE [dbo].[lista_contactos]  WITH CHECK ADD  CONSTRAINT [FK_contactos_estados] FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados_clientes] ([id])
ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[lista_contactos] CHECK CONSTRAINT [FK_contactos_estados]
GO
ALTER TABLE [dbo].[Notas]  WITH CHECK ADD  CONSTRAINT [FK_Notas_Usuarios] FOREIGN KEY([usuario_id])
REFERENCES [dbo].[Usuarios] ([ID])
GO
ALTER TABLE [dbo].[Notas] CHECK CONSTRAINT [FK_Notas_Usuarios]
GO
ALTER TABLE [dbo].[Requisitos]  WITH CHECK ADD FOREIGN KEY([CategoriaID])
REFERENCES [dbo].[CategoriasRequisitos] ([ID])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Requisitos]  WITH CHECK ADD FOREIGN KEY([PrioridadID])
REFERENCES [dbo].[Categorias] ([ID])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Tickets]  WITH CHECK ADD FOREIGN KEY([CategoriaID])
REFERENCES [dbo].[Categorias] ([ID])
GO
ALTER TABLE [dbo].[Tickets]  WITH CHECK ADD  CONSTRAINT [FK_Cliente] FOREIGN KEY([ClienteID])
REFERENCES [dbo].[clientes] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[Tickets] CHECK CONSTRAINT [FK_Cliente]
GO
ALTER TABLE [dbo].[Tickets]  WITH CHECK ADD  CONSTRAINT [FK_Estado] FOREIGN KEY([EstadoID])
REFERENCES [dbo].[EstadosTickets] ([ID])
GO
ALTER TABLE [dbo].[Tickets] CHECK CONSTRAINT [FK_Estado]
GO
ALTER TABLE [dbo].[Tickets]  WITH CHECK ADD  CONSTRAINT [FK_Responsable] FOREIGN KEY([ResponsableID])
REFERENCES [dbo].[Usuarios] ([ID])
GO
ALTER TABLE [dbo].[Tickets] CHECK CONSTRAINT [FK_Responsable]
GO
ALTER TABLE [dbo].[Tickets]  WITH CHECK ADD  CONSTRAINT [FK_TipoProducto] FOREIGN KEY([TipoProductoID])
REFERENCES [dbo].[TiposProductos] ([ID])
GO
ALTER TABLE [dbo].[Tickets] CHECK CONSTRAINT [FK_TipoProducto]
GO
ALTER TABLE [dbo].[TiposProductos]  WITH CHECK ADD  CONSTRAINT [FK_TiposProductos_Categoria] FOREIGN KEY([id_categoria_serv])
REFERENCES [dbo].[Categoria_Serv] ([ID])
GO
ALTER TABLE [dbo].[TiposProductos] CHECK CONSTRAINT [FK_TiposProductos_Categoria]
GO
ALTER TABLE [dbo].[Usuarios]  WITH CHECK ADD  CONSTRAINT [FK_usuarios_estados] FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados_clientes] ([id])
GO
ALTER TABLE [dbo].[Usuarios] CHECK CONSTRAINT [FK_usuarios_estados]
GO
ALTER TABLE [dbo].[Categoria]  WITH CHECK ADD CHECK  (([TipoCategoria]='Otros' OR [TipoCategoria]='Cosm?ticos' OR [TipoCategoria]='Productos M?dicos' OR [TipoCategoria]='Qu?micos'))
GO
ALTER TABLE [dbo].[Usuarios]  WITH CHECK ADD CHECK  (([Rol]='Admin' OR [Rol]='Usr'))
GO
USE [master]
GO
ALTER DATABASE [Kima] SET  READ_WRITE 
GO
